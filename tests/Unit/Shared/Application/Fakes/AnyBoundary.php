<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Application\Fakes;

use App\Shared\Application\Boundary;

/**
 * Class AnyBoundary
 * @package Tests\Unit\Shared\Domain\Fakes
 *
 * @property string $stringProp;
 * @property string $nullableProp;
 * @property int $intProp;
 * @property float $floatProp;
 * @property array $arrayProp;
 */
final class AnyBoundary extends Boundary
{
    protected string $stringProp;
    protected ?string $nullableProp;
    protected int $intProp;
    protected float $floatProp;
    protected array $arrayProp;

    public function getStringProp(): string
    {
        return strtoupper($this->stringProp);
    }
}
