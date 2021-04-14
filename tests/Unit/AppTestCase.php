<?php

declare(strict_types=1);

namespace Tests\Unit;

use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Faker\Factory;

abstract class AppTestCase extends TestCase
{
    protected static Generator $faker;

    public static function setUpBeforeClass(): void
    {
        self::$faker = Factory::create();
    }
}
