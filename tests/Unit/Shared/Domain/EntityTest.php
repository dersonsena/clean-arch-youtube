<?php

namespace Tests\Unit\Shared\Domain;

use App\Shared\Domain\Entity;
use InvalidArgumentException;
use Tests\Unit\AppTestCase;
use Tests\Unit\Shared\Domain\Fakes\AnyEntity;
use Tests\Unit\Shared\Domain\Fakes\AnyValueObject;
use TypeError;

class EntityTest extends AppTestCase
{
    public static function makeSut(array $values = []): Entity
    {
        if (!empty($values)) {
            return AnyEntity::create($values);
        }

        return AnyEntity::create([
            'stringProp' => self::$faker->words(2, true),
            'nullableProp' => null,
            'intProp' => self::$faker->randomDigit(),
            'floatProp' => self::$faker->randomFloat(),
            'arrayProp' => ['a', 'b', 'c', 'd'],
            'valueObjectProp' => new AnyValueObject('any value')
        ]);
    }

    public function testIfPropertyWithUnderscoreSeparatorWillPopulateEntity()
    {
        $values = [
            'string_prop' => self::$faker->words(2, true),
            'nullable_prop' => self::$faker->words(2, true),
            'int_prop' => self::$faker->randomDigit(),
            'float_prop' => self::$faker->randomFloat(),
            'array_prop' => ['a', 'b', 'c', 'd'],
            'value_object_prop' => new AnyValueObject('any value')
        ];

        $sut = self::makeSut($values);

        $this->assertSame(strtoupper($values['string_prop']), $sut->stringProp);
        $this->assertSame(strtoupper($values['nullable_prop']), $sut->nullableProp);
        $this->assertSame($values['int_prop'], $sut->intProp);
        $this->assertSame($values['float_prop'], $sut->floatProp);
        $this->assertSame($values['array_prop'], $sut->arrayProp);
        $this->assertSame($values['value_object_prop'], $sut->valueObjectProp);
    }

    public function testIfExceptionIsThrownWhenPropertyDoesNotExists()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Property 'invalidProp' doesn't exists in Entity Class '" . Entity::class . "'");

        self::makeSut([
            'invalidProp' => self::$faker->words(2, true)
        ]);
    }

    public function testIfExceptionIsThrownWhenNonexistentPropertyIsCalled()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Property 'invalidProp' doesn't exists in Entity Class '" . Entity::class . "'");

        $sut = self::makeSut();

        /** @noinspection PhpExpressionResultUnusedInspection */
        $sut->invalidProp;
    }

    public function testIfNullablePropertyIsNotFilledWhenNullValueIsProvided()
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

    public function testIfValuesIsChangedWhenNewValuesIsProvided()
    {
        $sut = self::makeSut([
            'stringProp' => self::$faker->words(2, true),
            'nullableProp' => null,
            'intProp' => self::$faker->randomDigit(),
            'floatProp' => self::$faker->randomFloat(),
            'arrayProp' => ['a', 'b', 'c', 'd'],
            'valueObjectProp' => new AnyValueObject('any value')
        ]);

        $values = [
            'stringProp' => self::$faker->words(2, true),
            'nullableProp' => self::$faker->words(2, true),
            'intProp' => self::$faker->randomDigit(),
            'floatProp' => self::$faker->randomFloat(),
            'arrayProp' => ['a', 'b', 'c', 'd'],
            'valueObjectProp' => new AnyValueObject('any value')
        ];

        $sut->fill($values);

        $this->assertSame(strtoupper($values['stringProp']), $sut->stringProp);
        $this->assertSame(strtoupper($values['nullableProp']), $sut->nullableProp);
        $this->assertSame($values['intProp'], $sut->intProp);
        $this->assertSame($values['floatProp'], $sut->floatProp);
        $this->assertSame($values['arrayProp'], $sut->arrayProp);
        $this->assertSame($values['valueObjectProp'], $sut->valueObjectProp);
    }
}
