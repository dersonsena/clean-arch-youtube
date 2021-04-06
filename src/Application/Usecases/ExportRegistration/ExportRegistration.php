<?php

declare(strict_types=1);

namespace App\Application\Usecases\ExportRegistration;

use App\Application\Contracts\PdfTool;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\ValueObjects\Cpf;
use DateTime;

final class ExportRegistration
{
    private LoadRegistrationRepository $repository;

    public function __construct(LoadRegistrationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $cpf = new Cpf($input->getRegistrationNumber());
        $registration = $this->repository->loadByRegistrationNumber($cpf);

        return new OutputBoundary([
            'name' => $registration->getName(),
            'email' => (string)$registration->getEmail(),
            'birthName' => $registration->getBirthDate()->format(DateTime::ATOM),
            'registrationNumber' => (string)$registration->getRegistrationNumber(),
            'registrationAt' => $registration->getRegistrationAt()->format(DateTime::ATOM)
        ]);
    }
}
