<?php

namespace Tests\Unit\Shared\Application;

use App\Shared\Application\Boundary;
use App\Shared\Application\Contracts\UseCaseBoundary;
use InvalidArgumentException;
use Tests\Unit\AppTestCase;
use Tests\Unit\Shared\Application\Fakes\AnyBoundary;
use TypeError;

class BoundaryTest extends AppTestCase
{
    public static function makeSut(array $values = []): UseCaseBoundary
    {
        if (!empty($values)) {
            return AnyBoundary::create($values);
        }

        return AnyBoundary::create([
            'stringProp' => self::$faker->words(2, true),
            'nullableProp' => null,
            'intProp' => self::$faker->randomDigit(),
            'floatProp' => self::$faker->randomFloat(),
            'arrayProp' => ['a', 'b', 'c', 'd'],
        ]);
    }

    public function testIfExceptionIsThrownWhenBoundaryPropertyDoesNotExists()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Property 'invalidProp' doesn't exists in Boundary Class '" . Boundary::class . "'");

        self::makeSut([
            'invalidProp' => self::$faker->words(2, true)
        ]);
    }

    public function testIfExceptionIsThrownWhenNonexistentPropertyIsCalled()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Property 'invalidProp' doesn't exists in Boundary Class '" . Boundary::class . "'");

        $sut = self::makeSut();

        /** @noinspection PhpExpressionResultUnusedInspection */
        $sut->invalidProp;
    }

    public function testIfNullableBoundaryPropertyIsNotFilledWhenNullValueIsProvided()
    {
        $sut = self::makeSut(['nullableProp' => null]);
        $this->assertSame(null, $sut->nullableProp);
    }

    public function testIfExceptionIsThrownWhenValueIsNullToNoNullableProperty()
    {
        $this->expectException(TypeError::class);

        $sut = self::makeSut(['intProp' => null]);
        $this->assertSame(null, $sut->intProp);
    }

    public function testIfPropertiesWithUnderscoreSeparatorWillPopulateBoundary()
    {
        $values = [
            'string_prop' => self::$faker->words(2, true),
            'nullable_prop' => self::$faker->words(2, true),
            'int_prop' => self::$faker->randomDigit(),
            'float_prop' => self::$faker->randomFloat(),
            'array_prop' => ['a', 'b', 'c', 'd']
        ];

        $sut = self::makeSut($values);

        $this->assertSame(strtoupper($values['string_prop']), $sut->stringProp);
        $this->assertSame($values['nullable_prop'], $sut->nullableProp);
        $this->assertSame($values['int_prop'], $sut->intProp);
        $this->assertSame($values['float_prop'], $sut->floatProp);
        $this->assertSame($values['array_prop'], $sut->arrayProp);
    }

    public function testIfCorrectValuesAreReturned()
    {
        $boundaryValues = [
            'stringProp' => self::$faker->words(2, true),
            'nullableProp' => self::$faker->words(2, true),
            'intProp' => self::$faker->randomDigit(),
            'floatProp' => self::$faker->randomFloat(),
            'arrayProp' => ['a', 'b', 'c', 'd']
        ];

        $sut = self::makeSut($boundaryValues);
        $values = $sut->values();

        $this->assertSame($values['stringProp'], strtoupper($boundaryValues['stringProp']));
        $this->assertSame($values['nullableProp'], $boundaryValues['nullableProp']);
        $this->assertSame($values['intProp'], $boundaryValues['intProp']);
        $this->assertSame($values['floatProp'], $boundaryValues['floatProp']);
        $this->assertSame($values['arrayProp'], $boundaryValues['arrayProp']);
    }
}
