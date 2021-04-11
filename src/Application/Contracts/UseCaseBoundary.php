<?php

declare(strict_types=1);

namespace App\Application\Contracts;

interface UseCaseBoundary
{
    /**
     * @return array
     */
    public function values(): array;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);
}
