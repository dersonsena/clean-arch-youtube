<?php

declare(strict_types=1);

namespace App\Application\Usecases\ExportRegistration;

use App\Shared\Application\Boundary;

/**
 * Class OutputData
 * @package App\Application\Usecases\ExportRegistration
 *
 * @property string $fullFileName
 */
final class OutputData extends Boundary
{
    protected string $fullFileName;
}
