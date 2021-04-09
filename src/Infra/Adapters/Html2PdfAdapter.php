<?php

declare(strict_types=1);

namespace App\Infra\Adapters;

use App\Application\Contracts\ExportRegistrationPdfExporter;
use App\Domain\Entities\Registration;
use HTML2PDF;
use HTML2PDF_exception;

final class Html2PdfAdapter implements ExportRegistrationPdfExporter
{
    public function generate(Registration $registration): string
    {
        $html2pdf = new HTML2PDF('P', 'A4');

        try {
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML(
                "<p>Nome: {$registration->getName()}</p><p>CPF: {$registration->getRegistrationNumber()}</p>"
            );

            return $html2pdf->output('', 'S');
        } catch (HTML2PDF_exception $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}
