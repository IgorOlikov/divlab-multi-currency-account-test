<?php

namespace App\UI\Request;

use Symfony\Bridge\Doctrine\Validator\Constraints as Assert;


class AccountRequestDTO
{
    //#[]
    public string $bankId;

    public string $primeCurrencyId;

}