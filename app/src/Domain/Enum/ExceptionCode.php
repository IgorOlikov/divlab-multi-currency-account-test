<?php

namespace App\Domain\Enum;

enum ExceptionCode: int
{
    case INVALID_AMOUNT = 422;
    case INSUFFICIENT_BALANCE = 409;

}
