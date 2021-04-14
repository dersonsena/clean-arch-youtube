<?php

declare(strict_types=1);

namespace App\Shared\Domain\Validation;

final class ValidationSetting
{
    private string $fieldName;
    private string $rule;
    private array $options;

    public function __construct(string $fieldName, string $rule, array $options = [])
    {
        $this->fieldName = $fieldName;
        $this->rule = $rule;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getRule(): string
    {
        return $this->rule;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
