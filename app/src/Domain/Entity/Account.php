<?php

namespace App\Domain\Entity;

use App\Domain\Enum\ExceptionCode;
use App\Domain\Exception\AlreadyExistsDomainException;
use App\Domain\Exception\UnsupportedCurrencyDomainException;
use InvalidArgumentException;

class Account
{
    private ?string $id = null;

    private Client $client;

    private Bank $bank;

    private ?Currency $primaryCurrency;

    /**
     * @var array<string, Currency> $currencies
     */
    private array $currencies = [];

    /**
     * @var array<string, Balance> $balances
     */
    private array $balances = [];

    /**
     * @param Client $client
     * @param Bank $bank
     * @param Currency|null $primaryCurrency
     * @param array<string, Currency> $currencies
     * @param array<string, Balance> $balances
     * @param string|null $id
     */
    public function __construct(
        Client   $client,
        Bank     $bank,
        Currency $primaryCurrency = null,
        array    $currencies = [],
        array    $balances = [],
        string   $id = null
    )
    {
        $this->id = $id;
        $this->client = $client;
        $this->bank = $bank;
        $this->primaryCurrency = $primaryCurrency;

        $this->addCurrenciesFromArray($currencies);
        $this->addBalancesFromArray($balances);
    }

    /**
     * @param Currency $currency
     * @return void
     *
     */
    public function addCurrency(Currency $currency): void
    {
        $this->checkCurrencyAlreadyExists($currency);

        $this->checkBankSupportsCurrency($currency);

        $this->currencies[$currency->getCode()] = $currency;

        $newBalance = new Balance(
            account: $this,
            currency: $currency
        );

        $this->addBalance($newBalance);
    }

    /**
     * Adds currency Balance to Account
     *
     * @param Balance $balance
     * @return void
     * @throws AlreadyExistsDomainException
     * @throws UnsupportedCurrencyDomainException
     */
    public function addBalance(Balance $balance): void
    {
        $this->checkBalanceAlreadyExists($balance);

        $this->checkAccountAndBankSupportsCurrency($balance->getCurrency());

        $this->balances[$balance->getBalanceCurrencyCode()] = $balance;
    }

    public function getBalance(Currency $currency): Balance
    {
        if (!isset($this->balances[$currency->getCode()])) {
            throw new UnsupportedCurrencyDomainException("Account Currency {$currency} is not supported", 422);
        }

        return $this->balances[$currency->getCode()];
    }

    /**
     * Adds an amount to Account Balance
     * Returns new balance amount in string type
     *
     * @param Currency $currency
     * @param string $amountToAdd
     * @return string
     * @throws UnsupportedCurrencyDomainException
     */
    public function deposit(Currency $currency, string $amountToAdd): string
    {
        $this->checkAccountAndBankSupportsCurrency($currency);

        $balance = $this->balances[$currency->getCode()];

        return $balance->addAmount($amountToAdd);
    }

    /**
     * Subtracts an amount from Account Balance
     * Returns new balance amount in string type
     *
     * @param Currency $currency
     * @param string $amountToSubtract
     * @return string
     * @throws UnsupportedCurrencyDomainException
     */
    public function withdraw(Currency $currency, string $amountToSubtract): string
    {
        $this->checkAccountAndBankSupportsCurrency($currency);

        $balance = $this->balances[$currency->getCode()];

        return $balance->subtractAmount($amountToSubtract);
    }

    /**
     * @param Currency $currency
     * @return Balance
     */
    public function getBalanceForOperation(Currency $currency): Balance
    {
        $this->checkAccountAndBankSupportsCurrency($currency);

        return $this->balances[$currency->getCode()];
    }

    /**
     * Checks that the Bank and Account support this Currency
     *
     * @param Currency $currency
     * @return void
     * @throws UnsupportedCurrencyDomainException
     */
    public function checkAccountAndBankSupportsCurrency(Currency $currency): void
    {
        $this->checkAccountSupportsCurrency($currency);
        $this->checkBankSupportsCurrency($currency);
    }

    /**
     * Checks that the Account support this currency
     *
     * @param Currency $currency
     * @return void
     * @throws UnsupportedCurrencyDomainException
     */
    public function checkAccountSupportsCurrency(Currency $currency): void
    {
        $currencyCode = $currency->getCode();

        if (!isset($this->balances[$currencyCode])) {
            throw new UnsupportedCurrencyDomainException("Account Currency {$currencyCode} is not supported");
        }
    }

    /**
     * Checks that the Bank support this Currency
     *
     * @param Currency $currency
     * @return void
     * @throws UnsupportedCurrencyDomainException
     */
    public function checkBankSupportsCurrency(Currency $currency): void
    {
        $currencyCode = $currency->getCode();

        if (!isset($this->bank->getCurrencies()[$currencyCode])) {
            throw new UnsupportedCurrencyDomainException("Bank not support this Currency {$currencyCode}");
        }
    }

    /**
     * Check that Account already supports this Currency
     *
     * @param Currency $currency
     * @return void
     * @throws AlreadyExistsDomainException
     */
    public function checkCurrencyAlreadyExists(Currency $currency): void
    {
        $currencyCode = $currency->getCode();

        if (isset($this->currencies[$currencyCode])) {
            throw new AlreadyExistsDomainException("Account Currency {$currencyCode} already exists");
        }
    }

    /**
     * Checks that Account already supports Balance with this Currency
     *
     * @param Balance $balance
     * @return void
     * @throws AlreadyExistsDomainException
     */
    public function checkBalanceAlreadyExists(Balance $balance): void
    {
        $balanceCurrencyCode = $balance->getBalanceCurrencyCode();

        if (isset($this->balances[$balanceCurrencyCode])) {
            throw new AlreadyExistsDomainException("Account already have Balance with Currency {$balanceCurrencyCode}");
        }
    }

    /**
     * Adds Currencies from array $code => $currency
     *
     * @param array<string, Currency> $currenciesArray
     * @return void
     * @throws InvalidArgumentException
     */
    public function addCurrenciesFromArray(array $currenciesArray): void
    {
        if (!empty($currencyArray)) {
            foreach ($currenciesArray as $code => $currency) {
                if (!is_string($code) || !$currency instanceof Currency) {
                    throw new InvalidArgumentException('Invalid currencies array format');
                }
                $this->addCurrency($currency);
            }
        }
    }

    /**
     * Adds Currencies from array $code => $balance
     *
     * @param array<string, Balance> $balancesArray
     * @return void
     * @throws InvalidArgumentException
     */
    public function addBalancesFromArray(array $balancesArray): void
    {
        if (!empty($balancesArray)) {
            foreach ($balancesArray as $code => $balance) {
                if (!is_string($code) || !$balance instanceof Balance) {
                    throw new InvalidArgumentException('Invalid balances array format');
                }
                $this->addBalance($balance);
            }
        }
    }

    public function __toString(): string
    {
        return $this->id;
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

    /**
     * @return array<string, Currency>
     */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    /**
     * @return array<string, Balance>
     */
    public function getBalances(): array
    {
        return $this->balances;
    }


}
