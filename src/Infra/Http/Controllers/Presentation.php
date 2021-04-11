<?php

declare(strict_types=1);

namespace App\Infra\Http\Controllers;

use App\Application\Contracts\UseCaseBoundary;

interface Presentation
{
    public function output(UseCaseBoundary $outputData): string;
}
