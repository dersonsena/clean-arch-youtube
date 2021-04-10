<?php

declare(strict_types=1);

namespace App\Infra\Cli\Commands;

use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Application\Usecases\ExportRegistration\InputBoundary;
use App\Infra\Http\Controllers\Presentation;

final class ExportRegistrationCommand
{
    private ExportRegistration $useCase;

    public function __construct(ExportRegistration $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): string
    {
        $inputBoundary = new InputBoundary(
            '01234567890',
            'xpto-cli.pdf',
            __DIR__ . '/../../../../storage/registrations'
        );

        $output = $this->useCase->handle($inputBoundary);

        return $presentation->output([
            'fullFileName' => $output->getFullFileName()
        ]);
    }
}
