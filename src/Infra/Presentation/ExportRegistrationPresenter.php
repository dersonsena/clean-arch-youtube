<?php

declare(strict_types=1);

namespace App\Infra\Presentation;

use App\Application\Contracts\OutputBoundary;
use App\Infra\Http\Controllers\Presentation;

final class ExportRegistrationPresenter implements Presentation
{
    public function output(OutputBoundary $outputData): string
    {
        return json_encode([
            'fullFileName1' => 'A - ' . $outputData->get('fullFileName'),
            'fullFileName2' => 'B - ' . $outputData->get('fullFileName'),
            'fullFileName3' => 'C - ' . $outputData->get('fullFileName')
        ]);
    }
}
