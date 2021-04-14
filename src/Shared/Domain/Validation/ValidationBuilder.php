<?php

declare(strict_types=1);

namespace App\Shared\Domain\Validation;

final class ValidationBuilder
{
    public const REQUIRED = 'required';
    public const MIN_LENGTH = 'min-length';
    public const MAX_LENGTH = 'max-length';
    // public const UUID = 'uuid'; (int $version = 4)
    // public const INTEGER = 'integer'; ()
    // public const DECIMAL = 'decimal'; ()
    // public const BOOLEAN = 'boolean'; ($trueValue = '1', $falseValue = '0', bool $strict = true)
    // public const COMPARE = 'compare'; (string $compareAttribute, string $operator = '=')
    // public const EMAIL = 'email'; ()
    // public const IN = 'in'; (array $range)
    // public const MATCH = 'match'; (array $pattern)
    // public const URL = 'url'; (array $validSchemas = ['http', 'https'], string $defaultScheme = null)
    // public const DATE = 'date'; (string $pattern = Date::BR) <~~~ Map regex patterns to constants to be used here
    // public const TIME = 'time'; ()
    // public const PHONE = 'phone'; (string $pattern = Phone::BR) <~~~ Map regex patterns to constants to be used here

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
        $this->validators[] = new ValidationSetting($this->fieldName, self::REQUIRED);
        return $this;
    }

    public function minLength(int $length): ValidationBuilder
    {
        $this->validators[] = new ValidationSetting($this->fieldName, self::MIN_LENGTH, [$length]);
        return $this;
    }

    public function maxLength(int $length): ValidationBuilder
    {
        $this->validators[] = new ValidationSetting($this->fieldName, self::MAX_LENGTH, [$length]);
        return $this;
    }

    public function build(): array
    {
        return $this->validators;
    }
}
