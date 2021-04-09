<?php

declare(strict_types=1);

namespace App\Infra\Adapters;

use App\Application\Contracts\Storage;

final class LocalStorageAdapter implements Storage
{
    public function store(string $fileName, string $path, string $content)
    {
        file_put_contents($path . DIRECTORY_SEPARATOR . $fileName, $content);
    }
}
