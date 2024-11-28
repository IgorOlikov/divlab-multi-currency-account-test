<?php

namespace App\Domain\Entity;

use App\Domain\Exception\AlreadyExistsDomainException;
use App\Domain\Exception\UnsupportedCurrencyDomainException;
use App\Domain\ValueObject\CurrencyValueObject;
use App\Domain\ValueObject\MoneyValueObject;
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
     * Adds Currency to Account and creates Balance
     *
     * @param Currency $currency
     * @return void
     *
     */
    public function attachCurrency(Currency $currency): void
    {
        $this->checkAccountCurrencyAlreadyExists($currency);

        $this->checkAccountBankSupportsCurrency($currency);

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
        $this->checkAccountCurrencyBalanceAlreadyExists($balance);

        $this->checkAccountAndBankSupportsCurrency($balance->getCurrency());

        $this->balances[$balance->getBalanceCurrencyCode()] = $balance;
    }

    public function getBalance(Currency $currency): Balance
    {
        $this->checkAccountSupportsCurrency($currency);

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
        $balance = $this->getBalanceForOperation($currency);

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
        $balance = $this->getBalanceForOperation($currency);

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
     * @param Currency $currency
     * @return void
     */
    public function detachCurrency(Currency $currency): void
    {
        $balanceForDelete = $this->getBalanceForOperation($currency);

        $amountInPrimaryCurrency = $balanceForDelete->convertToCurrency($this->primaryCurrency)->getAmount();

        $this->withdraw($currency, $balanceForDelete->getAmount());

        $this->deposit($this->primaryCurrency, $amountInPrimaryCurrency);

        unset($this->currencies[$currency->getCode()]);
        unset($this->balances[$balanceForDelete->getBalanceCurrencyCode()]);
    }


    /**
     * Returns Account summary balance amount
     *
     * @param Currency|null $currency
     * @return string
     */
    public function getAccountSummaryBalance(Currency $currency = null): string
    {
        $conversionCurrency = $currency ?? $this->primaryCurrency;

        $total = new MoneyValueObject('0.00', new CurrencyValueObject($conversionCurrency));

        foreach ($this->balances as $balance) {
            $total = $total->add($balance->convertToCurrency($conversionCurrency));
        }

        return $total->getAmount();
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
        $this->checkAccountBankSupportsCurrency($currency);
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

        if (!isset($this->currencies[$currencyCode])) {
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
    public function checkAccountBankSupportsCurrency(Currency $currency): void
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
    public function checkAccountCurrencyAlreadyExists(Currency $currency): void
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
    public function checkAccountCurrencyBalanceAlreadyExists(Balance $balance): void
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
             $this->validateCurrenciesArray($currenciesArray);
             foreach ($currenciesArray as $currency) {
                 $this->attachCurrency($currency);
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
            $this->validateBalancesArray($balancesArray);
            foreach ($balancesArray as $balance) {
                $this->addBalance($balance);
            }
        }
    }

    /**
     * @param array<string, Currency> $currenciesArray
     * @return void
     */
    public function validateCurrenciesArray(array $currenciesArray): void
    {
        foreach ($currenciesArray as $currency) {
            if (!$currency instanceof Currency) {
                throw new InvalidArgumentException('Invalid currencies array format');
            }
        }
    }

    /**
     * @param array<string, Balance> $balancesArray
     * @return void
     */
    public function validateBalancesArray(array $balancesArray): void
    {
        foreach ($balancesArray as $balance) {
            if (!$balance instanceof Currency) {
                throw new InvalidArgumentException('Invalid currencies array format');
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
