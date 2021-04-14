<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use DomainException;

final class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (empty($email)) {
            throw new DomainException('The Email cannot be empty.');
        }

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
