<?php

readonly class Money
{
    public function __construct(
        private int $amount,
        private string $currencyId
    )
    {}

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrencyId(): string
    {
        return $this->currencyId;
    }


}