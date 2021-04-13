<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation;

use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;
use RuntimeException;

final class Validator
{
    private array $errors = [];

    /**
     * @param FieldValidator[] $validators
     * @param array $values
     * @return array
     */
    public function validate(array $validators, array $values): array
    {
        foreach ($values as $fieldName => $value) {
            foreach ($validators as $validator) {
                if (!$validator instanceof FieldValidator) {
                    throw new RuntimeException('All validations must be instance of ' . FieldValidator::class);
                }

                if ($validator->getFieldName() !== $fieldName) {
                    continue;
                }

                try {
                    $validator->validate($value);
                } catch (ValidationFieldException $e) {
                    $this->errors[$e->getFieldName()][] = $e->getKey();
                }
            }
        }

        return $this->errors;
    }
}
