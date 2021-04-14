<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation;

use App\Shared\Domain\Validation\ValidationSetting;
use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;
use App\Shared\Infra\Validation\Validators\MaxLength;
use App\Shared\Infra\Validation\Validators\MinLength;
use App\Shared\Infra\Validation\Validators\Required;

abstract class Validator
{
    private static array $validatorMap = [
        'required' => Required::class,
        'min-length' => MinLength::class,
        'max-length' => MaxLength::class
    ];

    public static function validate($data, $validations): array
    {
        $errors = [];

        /** @var ValidationSetting $validationSetting */
        foreach ($validations as $validationSetting) {
            $output[$validationSetting->getFieldName()] = [];
            $value = static::extractValue($validationSetting->getFieldName(), $data);

            try {
                $validator = new self::$validatorMap[$validationSetting->getRule()](
                    $validationSetting->getFieldName(),
                    ...$validationSetting->getOptions()
                );

                if (!$validator instanceof FieldValidator) {
                    throw new ValidationException("Class '". get_class($validator) ."' must be type of " . FieldValidator::class);
                }

                $validator->validate($value);
            } catch (ValidationFieldException $e) {
                $errors[$e->getFieldName()][] = $e->getKey();
            } catch (ValidationException $e) {
                throw $e;
            }
        }

        return $errors;
    }

    private static function extractValue(string $fieldName, $data)
    {
        if (is_object($data) && isset($data->{$fieldName})) {
            return $data->{$fieldName};
        }

        if (is_array($data) && isset($data[$fieldName])) {
            return $data[$fieldName];
        }

        return null;
    }
}
