<?php

declare(strict_types=1);

namespace App\Infra\Validation;

use App\Shared\Application\Contracts\UseCaseBoundary;
use App\Shared\Infra\Validation\ValidationBuilder;
use App\Shared\Infra\Validation\Validator;

final class ExportRegistrationValidation
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validate(UseCaseBoundary $inputData): array
    {
        $validators = [
            ...ValidationBuilder::field('registrationNumber')->required()->minLength(11)->build(),
            ...ValidationBuilder::field('pdfFileName')->required()->build(),
            ...ValidationBuilder::field('path')->required()->build()
        ];

        return $this->validator->validate($validators, $inputData->values());
    }
}
