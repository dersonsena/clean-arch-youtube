<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Validators;

use App\Shared\Infra\Validation\Contracts\FieldValidator;
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
        $value = (string)$value;

        if (is_null($value) || empty($value)) {
            throw new ValidationFieldException($this->fieldName, 'required');
        }
    }
}
