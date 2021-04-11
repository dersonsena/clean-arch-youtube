<?php

declare(strict_types=1);

namespace App\Application\Usecases\ExportRegistration;

use App\Shared\Application\Boundary;

/**
 * Class InputData
 * @package App\Application\Usecases\ExportRegistration
 *
 * @property string $registrationNumber;
 * @property string $pdfFileName;
 * @property string $path;
 */
final class InputData extends Boundary
{
    protected string $registrationNumber;
    protected string $pdfFileName;
    protected string $path;

    public function getFullFileName(): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $this->pdfFileName;
    }
}
