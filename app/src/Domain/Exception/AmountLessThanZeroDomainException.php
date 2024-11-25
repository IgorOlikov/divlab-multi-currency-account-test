<?php

namespace App\Domain\Exception;

use Throwable;

class AmountLessThanZeroDomainException extends DomainException
{
    public function __construct(string $message = "", int $httpErrorCode = 400, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $httpErrorCode, $code, $previous);
    }
}