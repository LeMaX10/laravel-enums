<?php declare(strict_types=1);


namespace LeMaX10\Enums\Rules;


use Illuminate\Contracts\Validation\Rule;
use LeMaX10\Enums\Traits\EnumValidation;
use LeMaX10\Enums\Enum;

/**
 * Class EnumValue
 * @package LeMaX10\Enums\Rules
 */
class EnumValue implements Rule
{
    use EnumValidation;

    /**
     * @var Enum
     */
    private $enum;

    /**
     * EnumValue constructor.
     */
    public function __construct(string $enumClass)
    {
        if(!class_exists($enumClass)) {
            throw new \InvalidArgumentException('Cannot validate against the enum, the class '. $this->enumClass .' doesn\'t exist.');
        }

        $this->enum = $enumClass;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->enum::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute value you have entered is invalid.';
    }

    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString()
    {
        return  'enum:'. $this->enum;
    }
}