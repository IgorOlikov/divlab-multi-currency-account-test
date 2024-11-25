<?php

use App\Domain\Exception\AmountLessThanZeroDomainException;
use App\Domain\Exception\IncompatibleCurrenciesDomainException;
use App\Domain\Exception\InsufficientBalanceDomainException;

class Money
{
    private string $amount = '0.00';

    private string $currency;

    public function __construct(string $amount, string $currency)
    {
        if (bccomp($amount, '0.00', 2) === -1) {
            throw new AmountLessThanZeroDomainException('Amount cannot be less than 0.00.', 422);
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(Money $money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new IncompatibleCurrenciesDomainException('Currencies must match.');
        }

        return new self(bcadd($this->amount, $money->getAmount(), 2), $this->currency);
    }

    public function subtract(Money $money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new IncompatibleCurrenciesDomainException('Currencies must match.');
        }

        if (bccomp($this->amount, $money->getAmount(), 2) === -1) {
            throw new InsufficientBalanceDomainException('Insufficient balance.');
        }

        return new self(bcsub($this->amount, $money->getAmount(),2), $this->currency);
    }


}