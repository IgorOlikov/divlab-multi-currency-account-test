<?php

namespace App\Domain\Entity;

use Symfony\Component\Uid\Uuid;


class Bank
{
    private ?string $id = null;

    private string $name;

    /**
     *  @var array<string, Account> $accounts
     */
    private array $accounts;

    /**
     * @var array<string, Currency> $currencies
     */
    private array $currencies;

    /**
     * @var array<string, ExchangeRate> $exchangeRates
     */
    private  array $exchangeRates;


    public function __construct(
        string $name,
        string $id = null,
        array $accounts = [],
        array $currencies = [],
        array $exchangeRates = [],
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->accounts = $accounts;
        $this->currencies = $currencies;
        $this->exchangeRates = $exchangeRates;
    }

    /**
     * @param Client $client
     * @return Account
     */
    public function createNewAccount(Client $client): Account
    {
        $account = new Account(
            client: $client,
            bank: $this,
            id: (Uuid::v4())->toString()
        );

        $this->addAccount($account);

        return $account;
    }

    /**
     * @param Account $account
     * @return void
     */
    public function addAccount(Account $account): void
    {
        if (isset($this->accounts[$account->getId()])) {
            throw new \RuntimeException('Account already exists');
        }

        $this->accounts[$account->getId()] = $account;
    }

    /**
     * @param Currency $fromCurrency
     * @param Currency $toCurrency
     * @param string $rate
     * @return ExchangeRate
     */
    public function createExchangeRate(Currency $fromCurrency, Currency $toCurrency, string $rate): ExchangeRate
    {
        return new ExchangeRate($this, $fromCurrency, $toCurrency, $rate);
    }

    /**
     * @param ExchangeRate $exchangeRate
     * @return void
     */
    public function addExchangeRate(ExchangeRate $exchangeRate): void
    {
        $this->exchangeRates[$exchangeRate->generateExchangeRateCode()] = $exchangeRate;
    }

    /**
     * @param Currency $currency
     * @param Currency $conversionCurrency
     * @return ExchangeRate
     */
    public function getExchangeRate(Currency $currency, Currency $conversionCurrency): ExchangeRate
    {
        return $this->exchangeRates[$currency->getCode() .':'. $conversionCurrency->getCode()];
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

    public function getAccounts(): array
    {
        return $this->accounts;
    }

    public function setAccounts(array $accounts): void
    {
        $this->accounts = $accounts;
    }

    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function setCurrencies(array $currencies): void
    {
        $this->currencies = $currencies;
    }

    public function getExchangeRates(): array
    {
        return $this->exchangeRates;
    }

    public function setExchangeRates(array $exchangeRates): void
    {
        $this->exchangeRates = $exchangeRates;
    }




}