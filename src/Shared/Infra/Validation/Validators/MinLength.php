<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Validators;

use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;

final class MinLength implements FieldValidator
{
    private string $fieldName;
    private int $minLength;

    public function __construct(string $fieldName, int $minLength)
    {
        $this->fieldName = $fieldName;
        $this->minLength = $minLength;
    }

    public function validate($value): void
    {
        if (strlen($value) < $this->minLength) {
            throw new ValidationFieldException($this->fieldName, "min-length:{$this->minLength}");
        }
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}
