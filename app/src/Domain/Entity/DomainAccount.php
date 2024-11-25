<?php

namespace App\Domain\Entity;

use Symfony\Component\Uid\Uuid;


class DomainAccount
{

    private string $id;

    private string $primaryCurrency;

    private array $balances = [];

    public function __construct(string $id, string $primaryCurrency)
    {
        $this->id = $id;
        $this->primaryCurrency = $primaryCurrency;
    }

    public function addCurrency(string $currency): void
    {
        if (isset($this->balances[$currency])) {
            throw new \RuntimeException('Currency already exists');
        }

        $this->balances[$currency] = 0.0;
    }

    public function deposit(string $currency, float $amount): void
    {
        if (!isset($this->balances[$currency])) {
            throw new UnsupportedCurrencyException("Currency {$currency} is not supported");
        }

        $this->balances[$currency] += $amount;
    }

    public function withdraw(string $currency, float $amount): void
    {
        if (!isset($this->balances[$currency])) {
            throw new UnsupportedCurrencyException("Currency {$currency} is not supported");
        }

        if ($this->balances[$currency] < $amount) {
            throw new \RuntimeException('Insufficient funds');
        }

        $this->balances[$currency] -= $amount;
    }

    public function getBalance(string $currency): float
    {
        if (!isset($this->balances[$currency])) {
            throw new UnsupportedCurrencyException("Currency {$currency} is not supported");
        }

        return $this->balances[$currency];
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
