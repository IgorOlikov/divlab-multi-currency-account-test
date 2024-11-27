<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Money;

class Account
{

    private ?string $id = null;

    private Client $client;

    private Bank $bank;

    private Currency $primaryCurrency;

    /**
     * @var array<string, Currency> $currencies
     */
    private array $currencies = [];

    /**
     * @var array<string, Balance> $balances
     */
    private array $balances = [];

    public function __construct(
        Client   $client,
        Bank     $bank,
        Currency $primaryCurrency,
        array    $currencies = [],
        array    $balances = [],
        string   $id = null
    )
    {
        $this->id = $id;
        $this->client = $client;
        $this->bank = $bank;
        $this->primaryCurrency = $primaryCurrency;

        foreach ($currencies as $key => $currency) {
            if (!is_string($key) || !$currency instanceof Currency) {
                throw new \InvalidArgumentException('Invalid currencies array format');
            }
            $this->currencies[$key] = $currency;
        }

        foreach ($balances as $key => $balance) {
            if (!is_string($key) || !$balance instanceof Balance) {
                throw new \InvalidArgumentException('Invalid balances array format');
            }
            $this->balances[$key] = $balance;
        }
    }

    public function addCurrency(Currency $currency): void
    {
        if (isset($this->balances[$currency->__toString()])) {
            throw new \RuntimeException('Currency already exists');
        }

        $this->balances[$currency->__toString()] = $currency;
    }

    public function deposit(Currency $currency, Money $amount): void
    {
        if (!isset($this->balances[$currency])) {
            throw new UnsupportedCurrencyException("Currency {$currency} is not supported");
        }

        $this->balances[$currency] += $amount;
    }

    public function withdraw(Currency $currency, Money $amount): void
    {
        if (!isset($this->balances[(string)$currency])) {
            throw new UnsupportedCurrencyException("Currency {$currency} is not supported");
        }

        if ($this->balances[(string)$currency] < $amount) {
            throw new \RuntimeException('Insufficient funds');
        }

        $this->balances[(string)$currency] -= $amount;
    }

    public function getBalance(Currency $currency): float
    {
        if (!isset($this->balances[(string)$currency])) {
            throw new UnsupportedCurrencyException("Currency {$currency} is not supported");
        }

        return $this->balances[$currency];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setUser(Client $client): void
    {
        $this->client = $client;
    }

    public function getBank(): Bank
    {
        return $this->bank;
    }

    public function setBank(Bank $bank): void
    {
        $this->bank = $bank;
    }

    public function getPrimaryCurrency(): Currency
    {
        return $this->primaryCurrency;
    }

    public function setPrimaryCurrency(Currency $primaryCurrency): void
    {
        $this->primaryCurrency = $primaryCurrency;
    }

    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function setCurrencies(array $currencies): void
    {
        $this->currencies = $currencies;
    }

    public function getBalances(): array
    {
        return $this->balances;
    }

    public function setBalances(array $balances): void
    {
        $this->balances = $balances;
    }

}
