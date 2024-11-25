<?php

namespace App\Domain\ValueObject;

class ExchangeRate
{

    public function __construct(Currency $from, Currency $to, Money $rate)
    {
    }

    public function convert()
    {
        //bcmul()
    }
}