<?php

namespace Tests\Unit\Shared\Infra\Validation\Validators;

use App\Shared\Domain\Validation\ValidationBuilder;
use stdClass;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;
use App\Shared\Infra\Validation\Validators\Required;
use Tests\Unit\AppTestCase;
use Tests\Unit\Shared\Infra\Validation\Fakes\ClassWithToStringMethod;

class RequiredTest extends AppTestCase
{
    private static function makeSut(): Required
    {
        $fieldName = self::$faker->slug(1);
        return new Required($fieldName);
    }

    public function testIfExceptionIsThrownIfValueIsEmpty()
    {
        $sut = self::makeSut();

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage("Validation field error: {$sut->getFieldName()} | " . ValidationBuilder::REQUIRED);

        $sut->validate('');
    }

    public function testIfExceptionIsThrownIfValueIsNull()
    {
        $sut = self::makeSut();

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage("Validation field error: {$sut->getFieldName()} | " . ValidationBuilder::REQUIRED);

        $sut->validate(null);
    }

    public function testIfExceptionIsThrownIfValueIsEmptyArray()
    {
        $sut = self::makeSut();

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage("Validation field error: {$sut->getFieldName()} | " . ValidationBuilder::REQUIRED);

        $sut->validate([]);
    }

    public function testIfExceptionIsThrownIfValueIsObjectWithoutToStringImplementation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('To validate an object it must have the "__toString" method implemented.');

        $sut = self::makeSut();
        $sut->validate(new stdClass());
    }

    /**
     * @doesNotPerformAssertions
     * @throws ValidationFieldException
     * @throws ValidationException
     */
    public function testIfValidateRequiredCorrectly()
    {
        $sut = self::makeSut();
        $key = self::$faker->slug(1);
        $value = self::$faker->slug(1);

        $sut->validate(self::$faker->boolean());
        $sut->validate(new ClassWithToStringMethod());
        $sut->validate(self::$faker->randomNumber(4));
        $sut->validate(self::$faker->words(3, true));
        $sut->validate(self::$faker->randomFloat());
        $sut->validate([$key => $value]);
    }
}
