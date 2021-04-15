<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Validators;

use App\Shared\Domain\Validation\ValidationBuilder;
use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;

final class Required implements FieldValidator
{
    private string $fieldName;

    public function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    public function validate($value): void
    {
        if (is_bool($value)) {
            return;
        }

        if (is_object($value) && !method_exists($value, '__toString')) {
            throw new ValidationException('To validate an object it must have the "__toString" method implemented.');
        }

        $exception = new ValidationFieldException($this->fieldName, ValidationBuilder::REQUIRED);

        if (is_array($value) && count($value) === 0) {
            throw $exception;
        }

        if (is_array($value)) {
            return;
        }

        $value = (string)$value;

        if (is_null($value) || empty($value)) {
            throw $exception;
        }
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}
