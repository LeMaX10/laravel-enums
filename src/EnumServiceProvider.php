<?php declare(strict_types=1);

namespace LeMaX10\Enums;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('enum', static function ($attribute, $value, $parameters, $validator) {
            $enum = $parameters[0] ?? null;
            if (!class_exists($enum)) {
                return false;
            }

            $enumValidator = call_user_func([$enum, 'rule']);
            return $enumValidator->passes($attribute, $value);
        });
    }
}
