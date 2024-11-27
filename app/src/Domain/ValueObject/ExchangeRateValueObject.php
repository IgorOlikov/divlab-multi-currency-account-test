<?php

namespace App\Domain\ValueObject;

class ExchangeRateValueObject
{

    public function __construct(CurrencyValueObject $from, CurrencyValueObject $to, MoneyValueObject $rate)
    {
    }

    public function convert()
    {
        //bcmul()
    }
}