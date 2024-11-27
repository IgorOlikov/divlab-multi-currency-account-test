<?php


namespace App\Domain\Entity;

use App\Domain\Entity\Account;
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


    public function addAccount(Account $account): void
    {
        if (isset($this->balances[$account->__toString()])) {
            throw new \RuntimeException('Account already exists');
        }

        $this->accounts[$account->__toString()] = $account;
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