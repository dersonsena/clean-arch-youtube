<?php

declare(strict_types=1);

namespace App\Shared\Infra\Validation\Exceptions;

use Exception;
use Throwable;

final class ValidationException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
