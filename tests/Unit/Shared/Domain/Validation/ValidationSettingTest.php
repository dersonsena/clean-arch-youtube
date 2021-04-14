<?php

namespace Tests\Unit\Shared\Domain\Validation;

use App\Shared\Domain\Validation\ValidationSetting;
use Tests\Unit\AppTestCase;

class ValidationSettingTest extends AppTestCase
{
    public function testIfSettingIsReturnedWithCorrectValues()
    {
        $fieldName = self::$faker->slug(1);
        $rule = self::$faker->slug(1);
        $option1Key = self::$faker->slug(1);
        $option1Value = self::$faker->slug(1);
        $option2Key = self::$faker->slug(1);
        $option2Value = self::$faker->slug(1);

        $sut = new ValidationSetting($fieldName, $rule, [
            $option1Key => $option1Value,
            $option2Key => $option2Value,
        ]);

        $this->assertSame($fieldName, $sut->getFieldName());
        $this->assertSame($rule, $sut->getRule());

        $options = $sut->getOptions();

        $this->assertCount(2, $options);
        $this->assertArrayHasKey($option1Key, $options);
        $this->assertArrayHasKey($option2Key, $options);
        $this->assertSame($option1Value, $options[$option1Key]);
        $this->assertSame($option2Value, $options[$option2Key]);
    }
}
