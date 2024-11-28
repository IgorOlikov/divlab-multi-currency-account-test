<?php

namespace App\Domain\Entity;


use App\Domain\Trait\AmountValidator;
use App\Domain\ValueObject\CurrencyValueObject;
use App\Domain\ValueObject\MoneyValueObject;

class Balance
{
    use AmountValidator;

    private ?string $id;

    private Account $account;

    private Currency $currency;

    private string $amount = '0.00';

    public function __construct(
        Account  $account,
        Currency $currency,
        string   $amount = '0.00',
        string   $id = null
    )
    {
        $this->id = $id;
        $this->account = $account;
        $this->currency = $currency;

        $this->amount = $this->validateAmount($amount);
    }

    /**
     * Returns current Balance amount after subtraction
     *
     * @param string $amountToSubtract
     * @return string
     */
    public function subtractAmount(string $amountToSubtract): string
    {
        $currentMoney = new MoneyValueObject($this->amount, new CurrencyValueObject($this->currency));
        $subtractingMoney = new MoneyValueObject($amountToSubtract, new CurrencyValueObject($this->currency));
        $this->amount = $currentMoney->subtract($subtractingMoney)->getAmount();

        return $this->amount;
    }

    /**
     * Returns current Balance amount after addition
     *
     * @param string $amountToAdd
     * @return string
     */
    public function addAmount(string $amountToAdd): string
    {
        $currentMoney = new MoneyValueObject($this->amount, new CurrencyValueObject($this->currency));
        $addingMoney = new MoneyValueObject($amountToAdd, new CurrencyValueObject($this->currency));
        $this->amount = $currentMoney->add($addingMoney)->getAmount();

        return $this->amount;
    }

    /**
     * @param Currency $conversionCurrency
     * @return MoneyValueObject
     */
    public function convertToCurrency(Currency $conversionCurrency): MoneyValueObject
    {
        $balanceMoney = new MoneyValueObject($this->amount, new CurrencyValueObject($this->currency));

        if ($this->currency->getCode() === $conversionCurrency->getCode()) {
            $amountRate = '1.00';

        } else {
            $exchangeRate = $this->account->getBank()->getExchangeRate($this->currency, $conversionCurrency);

        $amountRate = $exchangeRate->getRate();
        }

        $exchangeRateMoney = new MoneyValueObject($amountRate, new CurrencyValueObject($conversionCurrency));

        return $balanceMoney->mul($exchangeRateMoney);
    }

    public function __toString(): string
    {
        return $this->currency->getCode();
    }

    public function getBalanceCurrencyCode(): string
    {
        return $this->currency->getCode();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $this->validateAmount($amount);
    }



}