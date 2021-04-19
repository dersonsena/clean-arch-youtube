<?php

namespace Tests\Unit\Shared\Domain\Fakes;

final class AnyValueObject
{
    private string $prop;

    public function __construct(string $prop)
    {
        $this->prop = $prop;
    }

    public function __toString(): string
    {
        return $this->prop;
    }
}
