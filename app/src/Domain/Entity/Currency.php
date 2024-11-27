<?php

namespace App\Domain\Entity;

class Currency
{
    private ?string $id;

    private string $name;

    public function __construct(string $currencyName, string $id = null)
    {
        $this->name = $currencyName;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }


}