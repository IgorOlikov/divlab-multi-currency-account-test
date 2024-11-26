<?php

namespace App\Application\Exception;

use Throwable;

class UserAlreadyExistsApplicationException extends ApplicationException
{
    public function __construct(
        string $message = "",
        private readonly int $httpErrorCode = 400,
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $httpErrorCode, $code, $previous);
    }

    public function getHttpErrorCode(): int
    {
        return $this->httpErrorCode;
    }
}