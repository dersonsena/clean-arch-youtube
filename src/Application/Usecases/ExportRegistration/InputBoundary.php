<?php

declare(strict_types=1);

namespace App\Application\Usecases\ExportRegistration;

final class InputBoundary
{
    private string $registrationNumber;
    private string $pdfFileName;
    private string $path;

    public function __construct(string $registrationNumber, string $pdfFileName, string $path)
    {
        $this->registrationNumber = $registrationNumber;
        $this->pdfFileName = $pdfFileName;
        $this->path = $path;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function getPdfFileName(): string
    {
        return $this->pdfFileName;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
