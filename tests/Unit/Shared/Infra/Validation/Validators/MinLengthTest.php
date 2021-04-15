<?php

namespace Tests\Unit\Shared\Infra\Validation\Validators;

use stdClass;
use App\Shared\Infra\Validation\Exceptions\ValidationException;
use App\Shared\Infra\Validation\Validators\MinLength;
use Tests\Unit\AppTestCase;

class MinLengthTest extends AppTestCase
{
    private static function makeSut(): MinLength
    {
        $fieldName = self::$faker->slug(1);
        $length = self::$faker->randomNumber(2);
        return new MinLength($fieldName, $length);
    }

    public function testIfExceptionIsThrowIfValueIsObjectWithoutToStringImplementation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('To validate an object it must have the "__toString" method implemented.');

        self::makeSut()->validate(new stdClass());
    }
}
