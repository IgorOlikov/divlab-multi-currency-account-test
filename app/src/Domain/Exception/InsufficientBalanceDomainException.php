<?php

namespace App\Domain\Exception;

use Throwable;

class InsufficientBalanceDomainException extends DomainException
{
    public function __construct(string $message = "", int $httpErrorCode = 422, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $httpErrorCode, $code, $previous);
    }
}