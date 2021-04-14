<?php

declare(strict_types=1);

namespace App\Shared\Domain\Validation;

final class ValidationBuilder
{
    /**
     * @var ValidationSetting[]
     */
    private array $validators = [];

    private string $fieldName;

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
        $this->validators[] = new ValidationSetting($this->fieldName, 'required');
        return $this;
    }

    public function minLength(int $length): ValidationBuilder
    {
        $this->validators[] = new ValidationSetting($this->fieldName, 'min-length', [$length]);
        return $this;
    }

    public function maxLength(int $length): ValidationBuilder
    {
        $this->validators[] = new ValidationSetting($this->fieldName, 'max-length', [$length]);
        return $this;
    }

    public function build(): array
    {
        return $this->validators;
    }
}
