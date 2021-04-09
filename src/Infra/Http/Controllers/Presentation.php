<?php

declare(strict_types=1);

namespace App\Infra\Http\Controllers;

interface Presentation
{
    public function output(array $data): string;
}
