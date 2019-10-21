<?php declare(strict_types=1);

namespace LeMaX10\Enums\Contracts;

/**
 * Interface Translatable
 * @package LeMaX10\Enums\Contracts
 */
interface Translatable
{
    /**
     * Translatable value
     * @return string
     */
    public function getTransValue(): string;
}
