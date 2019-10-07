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
     *
     */
    public static function bootModelEnums(): void
    {
        if (!property_exists(get_called_class(), 'enums')) {
            return;
        }

        static::extend(function ($model) {
            $model->bindEvent('model.beforeSetAttribute', static function ($key, $value) use ($model) {
                if ($model->isEnumAttribute($key) && !empty($value)) {
                    return $model->setEnumValue($key, $value);
                }
            });

            $model->bindEvent('model.beforeGetAttribute', static function ($key) use ($model) {
                if ($model->isEnumAttribute($key) && Arr::get($model->attributes, $key) !== null) {
                    return $model->getEnumValue($key);
                }
            });
        });
    }

    /**
     * @return array
     */
    public function getEnumsAttributes(): array
    {
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
        if (\is_string($value) && $enumObj::isValid($value)) {
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
}
