<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Validators;

use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;

final class MaxLength implements FieldValidator
{
    private string $fieldName;
    private int $maxLength;

    public function __construct(string $fieldName, int $maxLength)
    {
        $this->fieldName = $fieldName;
        $this->maxLength = $maxLength;
    }

    public function validate($value): void
    {
        if (strlen($value) > $this->maxLength) {
            throw new ValidationFieldException($this->fieldName, "max-length:{$this->maxLength}");
        }
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}
