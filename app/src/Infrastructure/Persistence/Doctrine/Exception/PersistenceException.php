<?php

namespace App\Infrastracture\Persistence\Doctrine\Exception;

use RuntimeException;
use Throwable;

class PersistenceException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}