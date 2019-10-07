<?php declare(strict_types=1);

namespace LeMaX10\Enums;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use LeMaX10\Enums\Rules\EnumValue;

/**
 * Class EnumServiceProvider
 * @package LeMaX10\Enums
 */
class EnumServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot(): void
    {
        $this->registerValidators();
    }

    /**
     *
     */
    private function registerValidators(): void
    {
        Validator::extend('enum', function ($attribute, $value, $parameters, $validator) {
            $enum = $parameters[0] ?? null;
            return (new EnumValue((string) $enum))->passes($attribute, $value);
        });
    }
}
