<?php

namespace App\Domain\Entity;


use App\Domain\ValueObject\Money;

class Balance
{
    private ?string $id;

    private Account $account;

    private Currency $currency;

    private string $amount;

    public function __construct(
        Account  $account,
        Currency $currency,
        Money    $amount,
        string   $id = null
    )
    {
        $this->id = $id;
        $this->account = $account;
        $this->currency = $currency;
        $this->amount = $amount->getAmount();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(Money $amount): void
    {
        $this->amount = $amount->getAmount();
    }


}