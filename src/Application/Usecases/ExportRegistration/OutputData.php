<?php

declare(strict_types=1);

namespace App\Application\Usecases\ExportRegistration;

use App\Application\Contracts\OutputBoundary;
use OutOfBoundsException;

final class OutputData implements OutputBoundary
{
    private string $fullFileName;

    public function __construct(string $fullFileName)
    {
        $this->fullFileName = $fullFileName;
    }

    public function values(string $key = null): array
    {
        return get_object_vars($this);
    }

    public function get(string $key)
    {
        if (!array_key_exists($key, $this->values())) {
            throw new OutOfBoundsException("Key '{$key}' doesn't exists in class '" . get_class() . "'");
        }

        return $this->values($key);
    }
}
