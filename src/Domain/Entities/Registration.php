<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Shared\Domain\Entity;
use App\Shared\Domain\Validation\ValidationBuilder;
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

    public function validationRules(): array
    {
        $name = ValidationBuilder::field('name')->required()->maxLength(25)->build();
        $cpf = ValidationBuilder::field('registrationNumber')->required()->maxLength(11)->build();
        $email = ValidationBuilder::field('email')->required()->build();

        return [
            ...$name, ...$cpf, ...$email
        ];
    }
}
