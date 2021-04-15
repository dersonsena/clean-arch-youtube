<?php

namespace Tests\Unit\Shared\Infra\Validation\Validators;

use stdClass;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use App\Shared\Infra\Validation\Exceptions\ValidationFieldException;
use App\Shared\Infra\Validation\Validators\Required;
use Tests\Unit\AppTestCase;
use Tests\Unit\Shared\Infra\Validation\Fakes\ClassWithToStringMethod;

class RequiredTest extends AppTestCase
{
    public function testIfExceptionIsThrowIfValueIsEmpty()
    {
        $fieldName = self::$faker->slug(1);

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage($fieldName);

        $sut = new Required($fieldName);
        $sut->validate('');
    }

    public function testIfExceptionIsThrowIfValueIsNull()
    {
        $fieldName = self::$faker->slug(1);

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage($fieldName);

        $sut = new Required($fieldName);
        $sut->validate(null);
    }

    public function testIfExceptionIsThrowIfValueIsEmptyArray()
    {
        $fieldName = self::$faker->slug(1);

        $this->expectException(ValidationFieldException::class);
        $this->expectExceptionMessage($fieldName);

        $sut = new Required($fieldName);
        $sut->validate([]);
    }

    public function testIfExceptionIsThrowIfValueIsObjectWithoutToStringImplementation()
    {
        $fieldName = self::$faker->slug(1);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('To validate an object it must have the "__toString" method implemented.');

        $sut = new Required($fieldName);
        $sut->validate(new StdClass());
    }

    /**
     * @doesNotPerformAssertions
     * @throws ValidationFieldException
     * @throws ValidationException
     */
    public function testIfValidateRequiredCorrectly()
    {
        $fieldName = self::$faker->slug(1);
        $key = self::$faker->slug(1);
        $value = self::$faker->slug(1);

        $sut = new Required($fieldName);

        $sut->validate(self::$faker->boolean());
        $sut->validate(new ClassWithToStringMethod());
        $sut->validate(self::$faker->randomNumber(4));
        $sut->validate(self::$faker->words(3, true));
        $sut->validate(self::$faker->randomFloat());
        $sut->validate([$key => $value]);
    }
}
