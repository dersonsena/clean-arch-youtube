<?php

namespace Tests\Unit\Shared\Infra\Validation\Validators;

use App\Shared\Domain\Validation\ValidationBuilder;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;
use stdClass;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use App\Shared\Infra\Validation\Validators\MinLength;
use Tests\Unit\AppTestCase;
use Tests\Unit\Shared\Infra\Validation\Fakes\ClassWithToStringMethod;

class MinLengthTest extends AppTestCase
{
    private static function makeSut(int $length = null): MinLength
    {
        $fieldName = self::$faker->slug(1);
        $minLength = $length ?? 6;
        return new MinLength($fieldName, $minLength);
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
        $this->expectExceptionMessage('You cannot insert a boolean value to Min Length validator.');

        self::makeSut()->validate(self::$faker->boolean());
    }

    public function testIfExceptionIsThrownWhenMinLengthIsNotEnough()
    {
        $sut = self::makeSut();

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage("Validation field error: {$sut->getFieldName()} | " . ValidationBuilder::MIN_LENGTH);

        $sut->validate(self::$faker->text(5));
    }

    public function testIfExceptionIsThrownWhenArrayIsNotHaveElementsEnough()
    {
        $sut = self::makeSut();

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage("Validation field error: {$sut->getFieldName()} | " . ValidationBuilder::MIN_LENGTH);

        $sut->validate([
            self::$faker->slug(1)
        ]);
    }

    /**
     * @doesNotPerformAssertions
     * @throws ValidationException
     * @throws ValidationFieldException
     */
    public function testIfValidateMinLengthCorrectly()
    {
        $sut = self::makeSut(5);

        $sut->validate(new ClassWithToStringMethod());
        $sut->validate(self::$faker->randomNumber(6));
        $sut->validate(self::$faker->realTextBetween(10));
        $sut->validate(self::$faker->randomFloat(6));
    }

    /**
     * @doesNotPerformAssertions
     * @throws ValidationException
     * @throws ValidationFieldException
     */
    public function testIfMinLengthCountSizeOfAnArray()
    {
        $sut = self::makeSut();

        $sut->validate([
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1),
            self::$faker->slug(1)
        ]);
    }
}
