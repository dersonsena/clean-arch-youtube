<?php

namespace Tests\Unit\Shared\Domain\Validation;

use App\Shared\Domain\Validation\ValidationBuilder;
use App\Shared\Domain\Validation\ValidationSetting;
use Tests\Unit\AppTestCase;

class ValidationBuilderTest extends AppTestCase
{
    public function testIfRequiredRuleIsAddedCorrectly()
    {
        $fieldName = self::$faker->slug(1);

        $sut = ValidationBuilder::field($fieldName);
        $validators = $sut->required()->build();

        $this->assertSame($fieldName, $sut->getFieldName());
        $this->assertCount(1, $validators);
        $this->assertInstanceOf(ValidationSetting::class, $validators[0]);
    }

    public function testIfMinLengthRuleIsAddedCorrectly()
    {
        $fieldName = self::$faker->slug(1);
        $length = self::$faker->randomNumber(3);

        $sut = ValidationBuilder::field($fieldName);
        $validators = $sut->minLength($length)->build();

        $this->assertSame($fieldName, $sut->getFieldName());
        $this->assertCount(1, $validators);
        $this->assertInstanceOf(ValidationSetting::class, $validators[0]);
    }

    public function testIfMaxLengthRuleIsAddedCorrectly()
    {
        $fieldName = self::$faker->slug(1);
        $length = self::$faker->randomNumber(3);

        $sut = ValidationBuilder::field($fieldName);
        $validators = $sut->maxLength($length)->build();

        $this->assertSame($fieldName, $sut->getFieldName());
        $this->assertCount(1, $validators);
        $this->assertInstanceOf(ValidationSetting::class, $validators[0]);
    }

    public function testIfBuildIsCountingNumberOfValidators()
    {
        $fieldName = self::$faker->slug(1);

        $sut = ValidationBuilder::field($fieldName);
        $validators = $sut->required()
            ->minLength(self::$faker->randomNumber(3))
            ->maxLength(self::$faker->randomNumber(3))
            ->build();

        $this->assertSame($fieldName, $sut->getFieldName());
        $this->assertCount(3, $validators);
    }
}
