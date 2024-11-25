<?php

namespace App\Application\Exception;

use RuntimeException;
use Throwable;

class ApplicationException extends RuntimeException
{
    public function __construct(
        string $message = "",
        private readonly int $httpErrorCode = 400,
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function getHttpErrorCode(): int
    {
        return $this->httpErrorCode;
    }
}