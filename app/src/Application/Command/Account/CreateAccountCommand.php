<?php

declare(strict_types=1);

namespace App\Application\Command\Account;



readonly class CreateAccountCommand
{

    public function __construct(
        private string $userId,
        private string $bankId,
        private string $currencyId,
    )
    {}

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getBankId(): string
    {
        return $this->bankId;
    }

    public function getCurrencyId(): string
    {
        return $this->currencyId;
    }



}