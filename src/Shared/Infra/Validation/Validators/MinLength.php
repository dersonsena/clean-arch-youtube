<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Validators;

use App\Shared\Domain\Validation\ValidationBuilder;
use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;

final class MinLength implements FieldValidator
{
    private string $fieldName;
    private int $length;

    public function __construct(string $fieldName, int $length)
    {
        if ($length === 0) {
            throw new ValidationException('You must to have insert a value greater than or equal to 1.');
        }

        $this->fieldName = $fieldName;
        $this->length = $length;
    }

    public function validate($value): void
    {
        if (is_bool($value)) {
            throw new ValidationException('You cannot insert a boolean value to Min Length validator.');
        }

        if (is_object($value) && !method_exists($value, '__toString')) {
            throw new ValidationException('To validate an object it must have the "__toString" method implemented.');
        }

        $exception = new ValidationFieldException($this->fieldName, ValidationBuilder::MIN_LENGTH . ":{$this->length}");

        if (is_array($value) && count($value) < $this->length) {
            throw $exception;
        }

        if (is_string($value) && strlen($value) < $this->length) {
            throw $exception;
        }
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}
