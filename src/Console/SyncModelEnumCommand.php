<?php namespace LeMaX10\Enums\Console;

use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LeMaX10\Enums\Enum;

/**
 * Class SyncModelEnumCommand
 * @package LeMaX10\Enums\Console
 */
class SyncModelEnumCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:enum:sync {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync enum column in table with local enum from Model';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $instance = $this->makeInstance($this->argument('model'));
        if (null === $instance) {
            $this->output->error(sprintf('Model [%s] not found', $this->argument('model')));
            return;
        }

        $enumList = $this->getEnumList($instance);
        if (null === $enumList) {
            $this->output->writeln(
                sprintf('Method [getEnumsAttributes] not called in model [%s]', $this->argument('model'))
            );
            return;
        }

        $this->sync($instance, $enumList);
    }

    /**
     * @param  string  $model
     * @return Model|null
     */
    private function makeInstance(string $model): ?Model
    {
        if (!class_exists($model)) {
            return null;
        }

        /** @var Model|Enum $instance */
        $instance = new $model;
        return $instance;
    }

    /**
     * @param  Model  $model
     * @return array|null
     */
    private function getEnumList(Model $model): ?array
    {
        if (!method_exists($model, 'getEnumsAttributes')) {
            return null;
        }

        return $model->getEnumsAttributes();
    }

    /**
     * @param  Model  $instance
     * @param  array  $enums
     */
    private function sync(Model $instance, array $enums): void
    {
        foreach ($enums as $column => $enum) {
            if (!class_exists($enum) || !method_exists($enum, 'values')) {
                $this->output->writeln(sprintf('Enum [%s] = ERROR: Not implemented Enum', $enum));
                continue;
            }

            $columnInDB = \DB::selectOne('show columns from '. $instance->getTable() .' LIKE \''. $column .'\'');
            if (!Str::startsWith($columnInDB->Type, ['enum'])) {
                $this->output->writeln('Enum ['. $column .'] = Not enum type, continue');
                continue;
            }

            $this->syncEnumColumn($instance, $enum, $columnInDB);
        }
    }

    /**
     * @param  Model  $instance
     * @param  string  $enum
     * @param  \stdClass  $columnInDB
     */
    private function syncEnumColumn(Model $instance, string $enum, \stdClass $columnInDB): void
    {
        try {
            preg_match('/^enum\((.*)\)$/', $columnInDB->Type, $values);
            $valuesInDB = array_map(static function(string $value): string {
                return trim($value, "'");
            }, explode(',', $values[1]));

            $valuesInEnum = array_values($enum::toArray());
            \DB::update('
                alter table '.$instance->gettable().'
                change '.$columnInDB->Field.' '.$columnInDB->Field.'
                enum(\''.implode('\',\'', $valuesInEnum).'\')
                '.(strtolower($columnInDB->Null) !== 'yes' ? ' not null' : '')
                .(!empty($columnInDB->Default) ? ' default \''.$columnInDB->Default.'\'' : '')
            );
            $this->output->writeln(sprintf('Enum [%s] = sync values', $enum));
        } catch(\PDOException $e) {
            if (Str::contains($e->getMessage(), 'Data truncated')) {
                $this->output->writeln(
                    sprintf(
                        'Enum [%s] = [ERROR] not sync. In data contains deleted values [%s] please change value and sync again.',
                        $enum,
                        join(',', array_diff($valuesInDB, $valuesInEnum))
                    )
                );

                return;
            }

            throw $e;
        }
    }
}
