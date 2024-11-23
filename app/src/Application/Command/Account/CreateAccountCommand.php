<?php

declare(strict_types=1);

namespace App\Application\Command\Account;



use App\Application\Command\CommandInterface;

readonly class CreateAccountCommand implements CommandInterface
{

    public function __construct(
        private string $userId,
        private string $bankId,
        private string $primeCurrencyId,
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

    public function getPrimeCurrencyId(): string
    {
        return $this->primeCurrencyId;
    }



}