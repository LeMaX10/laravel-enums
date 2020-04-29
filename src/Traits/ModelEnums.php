<?php declare(strict_types=1);

namespace LeMaX10\Enums\Traits;

use LeMaX10\Enums\Enum;
use Illuminate\Support\Arr;

/**
 * Trait ModelEnums
 * @package LeMaX10\Enums\Traits
 */
trait ModelEnums
{
    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        if ($this->isEnumAttribute($key) && Arr::get($this->attributes, $key) !== null) {
            return $this->getEnumValue($key);
        }

        return parent::getAttributeValue($key);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if ($this->isEnumAttribute($key) && !empty($value)) {
            $this->attributes[$key] = $this->setEnumValue($key, $value);
            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @return array
     */
    public function getEnumsAttributes(): array
    {
        if (!property_exists(get_called_class(), 'enums')) {
            return [];
        }

        return (array) $this->enums ?? [];
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function setEnumValue($key, $value): Enum
    {
        $enumObj = $this->getEnumsAttributes()[$key];
        if (\is_string($value) && call_user_func([$enumObj, 'isValid'], $value)) {
            $value = new $enumObj($value);
        }

        if (!$value instanceof Enum) {
            throw new \InvalidArgumentException('Enum is not correct');
        }

        return $value;
    }

    /**
     * @param $key
     *
     * @return null|Enum
     */
    public function getEnumValue($key): ?Enum
    {
        if (!isset($this->attributes[$key])) {
            return null;
        }

        if (!$this->attributes[$key] instanceof Enum) {
            $enumClass = $this->getEnumsAttributes()[$key];
            $this->attributes[$key] = new $enumClass($this->attributes[$key]);
        }

        return $this->attributes[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isEnumAttribute(string $key): bool
    {
        return array_key_exists($key, $this->getEnumsAttributes());
    }

    /**
     * Determine if the new and old values for a given key are equivalent.
     *
     * @param  string $key
     * @param  mixed  $current
     * @return bool
     */
    protected function originalIsEquivalent($key, $current)
    {
        if ($this->isEnumAttribute($key)) {
            $originalValue = $this->getOriginal($key);
            if (!empty($originalValue)) {
                $enumClass = $this->getEnumsAttributes()[$key];
                $original = new $enumClass();

                return $original->equals($this->getEnumValue($key));
            }
        }

        return parent::originalIsEquivalent($key, $current);
    }
}
