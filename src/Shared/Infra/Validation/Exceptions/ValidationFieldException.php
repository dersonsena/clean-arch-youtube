<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Exceptions;

use Exception;
use Throwable;

final class ValidationFieldException extends Exception
{
    private string $fieldName;
    private string $key;

    public function __construct(string $fieldName, string $key, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Validation field error: {$fieldName} | {$key}", $code, $previous);
        $this->fieldName = $fieldName;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
