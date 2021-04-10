<?php

declare(strict_types=1);

namespace App\Infra\Adapters;

use App\Application\Contracts\ExportRegistrationPdfExporter;
use App\Domain\Entities\Registration;
use Dompdf\Dompdf;

final class DomPdfAdapter implements ExportRegistrationPdfExporter
{
    public function generate(Registration $registration): string
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml("<p>Nome: {$registration->getName()}</p><p>CPF: {$registration->getRegistrationNumber()}</p>");
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->output();
    }
}
