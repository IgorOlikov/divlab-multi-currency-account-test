<?php

namespace App\Domain\Service;

class CurrencyExchangeService
{
    public function convert(string $fromCurrency, string $toCurrency, int $exchangeRate ,float $amount): float
    {

        return $amount * $exchangeRate;
    }
}