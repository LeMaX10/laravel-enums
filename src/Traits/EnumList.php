<?php


namespace LeMaX10\Enums\Traits;


use LeMaX10\Enums\Contracts\Translatable;
use LeMaX10\Enums\Enum;

/**
 * Trait EnumList
 * @package LeMaX10\Enums\Traits
 */
trait EnumList
{
    /**
     * @var bool
     */
    protected $keyByValue = true;

    /**
     * Get Enum items list with value tranlatable
     * @param $enum
     * @return array
     */
    public function getEnumTranslatableList($enum): array
    {
        $values = $enum::values();

        return  $this->makeEnumList($values, static function(Translatable $enum) {
            return $enum->getTransValue();
        });
    }

    /**
     * Get Enum items list
     *
     * @param $enum
     * @return array
     */
    public function getEnumList($enum): array
    {
        $values = $enum::values();

        return  $this->makeEnumList($values, static function(Enum $enum) {
            return $enum->getValue();
        });
    }

    /**
     * @param array $enums
     * @param \Closure $valueCallback
     * @return array
     */
    protected function makeEnumList(array $enums, \Closure $valueCallback): array
    {
        $list = [];
        foreach($enums as $key => $enum) {
            if ($this->keyByValue) {
                $key = $enum->getValue();
            }

            $list[$key] = $valueCallback($enum);
        }

        return $list;
    }
}
