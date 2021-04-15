<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infra\Validation\Fakes;

use Faker\Factory;

class ClassWithToStringMethod
{
    public function __toString(): string
    {
        return Factory::create()->words(3, true);
    }
}
