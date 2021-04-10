<?php

declare(strict_types=1);

namespace App\Infra\Http\Controllers;

use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Application\Usecases\ExportRegistration\InputBoundary;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ExportRegistrationController
{
    private Request $request;
    private Response $response;
    private ExportRegistration $useCase;

    public function __construct(
        Request $request,
        Response $response,
        ExportRegistration $useCase
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): Response
    {
        $inputBoundary = new InputBoundary(
            '01234567890',
            'xpto-dompdf.pdf',
            __DIR__ . '/../../../../storage/registrations'
        );

        $output = $this->useCase->handle($inputBoundary);

        $this->response
            ->getBody()
            ->write($presentation->output([
                'fullFileName' => $output->getFullFileName()
            ]));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
