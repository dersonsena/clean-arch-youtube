<?php

declare(strict_types=1);

namespace App\Application\Helpers;

use OutOfBoundsException;

trait BoundaryHelpers
{
    public function values(): array
    {
        return get_object_vars($this);
    }

    public function get(string $key)
    {
        if (!array_key_exists($key, $this->values())) {
            throw new OutOfBoundsException("Key '{$key}' doesn't exists in class '" . get_class() . "'");
        }

        return $this->values()[$key];
    }
}
