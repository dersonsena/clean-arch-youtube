<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Shared\Domain\Entity;
use DateTimeInterface;

/**
 * Class Registration
 * @package App\Domain\Entities
 *
 * @property string $name;
 * @property Email $email;
 * @property DateTimeInterface $birthDate;
 * @property Cpf $registrationNumber;
 * @property DateTimeInterface $registrationAt;
 */
final class Registration extends Entity
{
    protected string $name;
    protected Email $email;
    protected DateTimeInterface $birthDate;
    protected Cpf $registrationNumber;
    protected DateTimeInterface $registrationAt;
}
