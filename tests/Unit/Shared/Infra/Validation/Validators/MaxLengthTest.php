<?php

namespace Tests\Unit\Shared\Infra\Validation\Validators;

use App\Shared\Domain\Validation\ValidationBuilder;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;
use App\Shared\Infra\Validation\Validators\MaxLength;
use stdClass;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use Tests\Unit\AppTestCase;
use Tests\Unit\Shared\Infra\Validation\Fakes\ClassWithToStringMethod;

class MaxLengthTest extends AppTestCase
{
    private static function makeSut(int $length = null): MaxLength
    {
        $fieldName = self::$faker->slug(1);
        $length = $length ?? 6;
        return new MaxLength($fieldName, $length);
    }

    public function testIfExceptionIsThrownIfValueIsObjectWithoutToStringImplementation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('To validate an object it must have the "__toString" method implemented.');

        self::makeSut()->validate(new stdClass());
    }

    public function testIfExceptionIsThrownIfMinLengthEqualsZero()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('You must to have insert a value greater than or equal to 1.');

        self::makeSut(0)->validate(self::$faker->words(2, true));
    }

    public function testIfExceptionIsThrownBooleanValueIsProvided()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('You cannot insert a boolean value to Max Length validator.');

        self::makeSut()->validate(self::$faker->boolean());
    }

    public function testIfExceptionIsThrownWhenMaxLengthIsReached()
    {
        $sut = self::makeSut();

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage("Validation field error: {$sut->getFieldName()} | " . ValidationBuilder::MAX_LENGTH);

        $sut->validate(self::$faker->text(15));
    }

    public function testIfExceptionIsThrownWhenArrayHaveReachedElementsCount()
    {
        $sut = self::makeSut();

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage("Validation field error: {$sut->getFieldName()} | " . ValidationBuilder::MAX_LENGTH);

        $sut->validate([
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1)
        ]);
    }

    /**
     * @doesNotPerformAssertions
     * @throws ValidationException
     * @throws ValidationFieldException
     */
    public function testIfValidateMaxLengthCorrectly()
    {
        $sut = self::makeSut();

        $sut->validate(new ClassWithToStringMethod());
        $sut->validate(self::$faker->randomNumber(5));
        $sut->validate('123456');
        $sut->validate(self::$faker->randomFloat(5));
    }

    /**
     * @doesNotPerformAssertions
     * @throws ValidationException
     * @throws ValidationFieldException
     */
    public function testIfMaxLengthCountSizeOfAnArray()
    {
        $sut = self::makeSut();

        $sut->validate([
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1)
        ]);
    }
}
