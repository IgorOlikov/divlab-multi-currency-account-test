<?php

namespace App\Domain\Entity;

use App\Domain\Trait\AmountValidator;

class ExchangeRate
{
    use AmountValidator;

    private ?string $id;

    private Bank $bank;

    private Currency $fromCurrency;

    private Currency $toCurrency;

    private string $exchangeRate;

    public function __construct(
        Bank             $bank,
        Currency         $fromCurrency,
        Currency         $toCurrency,
        string           $rate,
        string           $id = null
    )
    {
        $this->id = $id;
        $this->bank = $bank;
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
        $this->exchangeRate = $this->validateAmount($rate);
    }

    public function generateExchangeRateCode(): string
    {
        return $this->fromCurrency->getCode() . ':' . $this->toCurrency->getCode();
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

    public function setRate(string $rate): string
    {
        $this->exchangeRate = $this->validateAmount($rate);
        return $this->exchangeRate;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->exchangeRate;
    }


}