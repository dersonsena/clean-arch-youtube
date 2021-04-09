<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use DomainException;

final class Email
{
    private string $email = 'a@email.com.br';

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException('Email is not valid');
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
