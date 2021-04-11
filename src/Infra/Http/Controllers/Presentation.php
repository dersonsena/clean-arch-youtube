<?php

declare(strict_types=1);

namespace App\Infra\Http\Controllers;

use App\Application\Contracts\OutputBoundary;

interface Presentation
{
    public function output(OutputBoundary $outputData): string;
}
