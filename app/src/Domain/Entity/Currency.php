<?php

namespace App\Domain\Entity;

class Currency
{
    private ?string $id;

    private string $code;

    public function __construct(string $currencyCode, string $id = null)
    {
        $this->code = strtoupper($currencyCode);
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $currencyCode): void
    {
        $this->code = strtoupper($currencyCode);
    }

    public function __toString(): string
    {
        return $this->code;
    }


}