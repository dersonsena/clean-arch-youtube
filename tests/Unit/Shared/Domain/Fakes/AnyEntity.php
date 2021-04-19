<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Fakes;

use App\Shared\Domain\Entity;

/**
 * Class AnyEntity
 * @package Tests\Unit\Shared\Domain\Fakes
 *
 * @property string $stringProp;
 * @property string $nullableProp;
 * @property int $intProp;
 * @property float $floatProp;
 * @property array $arrayProp;
 * @property AnyValueObject $valueObjectProp;
 */
final class AnyEntity extends Entity
{
    protected string $stringProp;
    protected ?string $nullableProp;
    protected int $intProp;
    protected float $floatProp;
    protected array $arrayProp;
    protected AnyValueObject $valueObjectProp;

    public function setStringProp(string $stringProp): AnyEntity
    {
        $this->stringProp = strtoupper($stringProp);
        return $this;
    }

    public function getNullableProp(): ?string
    {
        return is_null($this->nullableProp) ? null : strtoupper($this->nullableProp);
    }
}
