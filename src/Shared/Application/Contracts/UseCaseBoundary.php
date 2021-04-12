<?php

declare(strict_types=1);

namespace App\Shared\Application\Contracts;

/**
 * Interface UseCaseBoundary
 * @package App\Shared\Application\Contracts
 * @author Kilderson Sena <dersonsena@gmail.com>
 */
interface UseCaseBoundary
{
    /**
     * Associative array such as `'property' => 'value'` with all boundary values
     * @return array
     */
    public function values(): array;

    /**
     * Get a boundary value by property
     * @param string $property
     * @return mixed
     */
    public function get(string $property);
}
