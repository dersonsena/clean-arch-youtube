<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Contracts;

interface FieldValidator
{
    public function validate($value): void;
}
