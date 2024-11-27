<?php

namespace App\Domain\ValueObject;

class CurrencyValueObject
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = strtoupper($code);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function equals(CurrencyValueObject $currency): bool
    {
        return $this->code === $currency->getCode();
    }

}