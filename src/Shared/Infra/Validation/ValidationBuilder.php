<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation;

use App\Shared\Infra\Validation\Contracts\FieldValidator;
use App\Shared\Infra\Validation\Validators\MaxLength;
use App\Shared\Infra\Validation\Validators\MinLength;
use App\Shared\Infra\Validation\Validators\Required;

final class ValidationBuilder
{
    private string $fieldName;

    /**
     * @var FieldValidator[]
     */
    private array $validators;

    private function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    public static function field(string $fieldName): ValidationBuilder
    {
        return new ValidationBuilder($fieldName);
    }

    public function required(): ValidationBuilder
    {
        $this->validators[] = new Required($this->fieldName);
        return $this;
    }

    public function minLength(int $minLength): ValidationBuilder
    {
        $this->validators[] = new MinLength($this->fieldName, $minLength);
        return $this;
    }

    public function maxLength(int $maxLength): ValidationBuilder
    {
        $this->validators[] = new MaxLength($this->fieldName, $maxLength);
        return $this;
    }

    /**
     * @return FieldValidator[]
     */
    public function build(): array
    {
        return $this->validators;
    }
}
