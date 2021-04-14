<?php

namespace Tests\Unit\Shared\Domain\Validation;

use App\Shared\Domain\Validation\ValidationSetting;
use PHPUnit\Framework\TestCase;

class ValidationSettingTest extends TestCase
{
    public function testIfSettingIsReturnedWithCorrectValues()
    {
        $sut = new ValidationSetting('any_field_name', 'any_rule', [
            'any_option_1' => 'any_value_1',
            'any_option_2' => 'any_value_2',
        ]);

        $this->assertSame('any_field_name', $sut->getFieldName());
        $this->assertSame('any_rule', $sut->getRule());

        $options = $sut->getOptions();

        $this->assertCount(2, $options);
        $this->assertArrayHasKey('any_option_1', $options);
        $this->assertArrayHasKey('any_option_2', $options);
        $this->assertSame('any_value_1', $options['any_option_1']);
        $this->assertSame('any_value_2', $options['any_option_2']);
    }
}
