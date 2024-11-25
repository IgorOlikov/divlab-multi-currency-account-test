<?php

namespace App\Domain\ValueObject;

class Currency
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = strtoupper($name);
    }

    public function getCode(): string
    {
        return $this->name;
    }

}