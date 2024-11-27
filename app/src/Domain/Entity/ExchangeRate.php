<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Money;
use Doctrine\ORM\Mapping as ORM;

class ExchangeRate
{
    private ?string $id;

    private Bank $bank;

    private Currency $fromCurrency;

    private Currency $toCurrency;

    private string $exchangeRate;

    public function __construct(
        Bank     $bank,
        Currency $fromCurrency,
        Currency $toCurrency,
        Money    $money,
        string   $id = null
    )
    {
        $this->id = $id;
        $this->bank = $bank;
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
        $this->exchangeRate = $money->getAmount();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getBank(): Bank
    {
        return $this->bank;
    }

    public function setBank(Bank $bank): void
    {
        $this->bank = $bank;
    }

    public function getFromCurrency(): Currency
    {
        return $this->fromCurrency;
    }

    public function setFromCurrency(Currency $fromCurrency): void
    {
        $this->fromCurrency = $fromCurrency;
    }

    public function getToCurrency(): Currency
    {
        return $this->toCurrency;
    }

    public function setToCurrency(Currency $toCurrency): void
    {
        $this->toCurrency = $toCurrency;
    }

    public function getExchangeRate(): string
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(string $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }


}