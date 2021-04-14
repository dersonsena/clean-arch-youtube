<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Validators;

use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;

final class MaxLength implements FieldValidator
{
    private string $fieldName;
    private int $length;

    public function __construct(string $fieldName, int $length)
    {
        $this->fieldName = $fieldName;
        $this->length = $length;
    }

    public function validate($value): void
    {
        $value = (string)$value;

        if (strlen($value) > $this->length) {
            throw new ValidationFieldException($this->fieldName, "max-length:{$this->length}");
        }
    }
}
