<?php

declare(strict_types=1);

namespace App\Application\Usecases\ExportRegistration;

final class InputBoundary
{
    private string $registrationNumber;

    public function __construct(string $registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }
}
