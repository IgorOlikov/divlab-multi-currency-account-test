<?php

namespace App\Domain\ValueObject;


use App\Domain\Exception\IncompatibleCurrenciesDomainException;
use App\Domain\Exception\InsufficientBalanceDomainException;
use App\Domain\Trait\AmountValidator;

class MoneyValueObject
{
    use AmountValidator;

    private string $amount = '0.00';

    private CurrencyValueObject $currency;

    public function __construct(string $amount, CurrencyValueObject $currency)
    {
        $this->amount = $this->validateAmount($amount);
        $this->currency = $currency;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): CurrencyValueObject
    {
        return $this->currency;
    }

    public function add(MoneyValueObject $money): MoneyValueObject
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new IncompatibleCurrenciesDomainException('Currencies must match.');
        }

        return new self(bcadd($this->amount, $money->getAmount(), 2), $this->currency);
    }

    public function subtract(MoneyValueObject $money): MoneyValueObject
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new IncompatibleCurrenciesDomainException('Currencies must match.');
        }

        if (bccomp($this->amount, $money->getAmount(), 2) === -1) {
            throw new InsufficientBalanceDomainException('Insufficient balance.');
        }

        return new self(bcsub($this->amount, $money->getAmount(),2), $this->currency);
    }

    public function mul(MoneyValueObject $money): MoneyValueObject
    {
        return new self(bcmul($this->amount, $money->getAmount(), 2), $this->currency);
    }


}