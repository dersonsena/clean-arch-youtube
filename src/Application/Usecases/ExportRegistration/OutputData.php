<?php

declare(strict_types=1);

namespace App\Application\Usecases\ExportRegistration;

use App\Application\Contracts\OutputBoundary;
use App\Application\Helpers\BoundaryHelpers;

final class OutputData implements OutputBoundary
{
    use BoundaryHelpers;

    private string $fullFileName;

    public function __construct(string $fullFileName)
    {
        $this->fullFileName = $fullFileName;
    }
}
