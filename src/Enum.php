<?php declare(strict_types=1);

namespace LeMaX10\Enums;

use LeMaX10\Enums\Rules\EnumValue;
use MyCLabs\Enum\Enum as BaseEnum;

/**
 * Class Enum
 * @package LeMaX10\Enums
 */
class Enum extends BaseEnum
{
    /**
     * ValidationEnum Value Rule
     * @return EnumValue
     */
    public static function rule(): EnumValue
    {
        return new EnumValue(static::class);
    }
}