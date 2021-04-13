<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Contracts;

use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;

interface FieldValidator
{
    /**
     * @return string
     */
    public function getFieldName(): string;

    /**
     * @param $value
     * @throws ValidationFieldException
     */
    public function validate($value): void;
}
