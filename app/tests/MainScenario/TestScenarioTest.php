<?php

namespace App\Tests\MainScenario;

use App\Domain\Entity\Bank;
use App\Domain\Entity\Client;
use App\Domain\Entity\Currency;
use PHPUnit\Framework\TestCase;

class TestScenarioTest extends TestCase
{
    public function test_scenario(): void
    {

        // ---------   SET UP ------------------------------
        $bank = new Bank(name: 'Random Bank');

        $rubCurrency = new Currency('RUB');

        $eurCurrency = new Currency("EUR");

        $usdCurrency = new Currency('USD');

        $bank->addCurrency($rubCurrency);
        $bank->addCurrency($eurCurrency);
        $bank->addCurrency($usdCurrency);

        // RUB:EUR
        // EUR:RUB
        $rubEurExgRate = $bank->createExchangeRate($rubCurrency, $eurCurrency, '0.01');
        $uerRubExgRate = $bank->createExchangeRate($eurCurrency, $rubCurrency, '119.44');

        // RUB:USD
        // USD:RUB
        $rubUsdExgRate = $bank->createExchangeRate($rubCurrency, $usdCurrency, '0.01');
        $usdRubExgRate = $bank->createExchangeRate($usdCurrency, $rubCurrency, '113.15');

        // EUR:USD
        // USD:EUR
        $eurUsdExgRate = $bank->createExchangeRate($eurCurrency, $usdCurrency, '1.06');
        $usdEurExgRate = $bank->createExchangeRate($usdCurrency, $eurCurrency, '0.95');

        $client = new Client('Ivan Ivanov', 'ivanov@example.com', 'password');
        //------------ SET UP ----------------------------


        // ------- test scenario 1 --------------

        $account = $bank->createNewAccount($client);

        $account->attachCurrency($rubCurrency);
        $account->attachCurrency($eurCurrency);
        $account->attachCurrency($usdCurrency);


        $account->setPrimaryCurrency($rubCurrency);

        $supportedCurrencies = $account->getCurrencies();

        $this->assertEquals(
            [
                'RUB' => $rubCurrency,
                'EUR' => $eurCurrency,
                'USD' => $usdCurrency
            ],
            $supportedCurrencies
        );


        $account->deposit($rubCurrency, '1000.00');
        $account->deposit($eurCurrency, '50.00');
        $account->deposit($usdCurrency, '50.00');


        //------- test scenario 2 ---------------

        $summaryBalanceInPrimeCurrencyRub = $account->getAccountSummaryBalance();

        $this->assertEquals('12629.50', $summaryBalanceInPrimeCurrencyRub);

        $summaryBalanceInCurrencyUsd = $account->getAccountSummaryBalance($usdCurrency);

        $this->assertEquals('113.00', $summaryBalanceInCurrencyUsd);

        $summaryBalanceInCurrencyEur = $account->getAccountSummaryBalance($eurCurrency);

        $this->assertEquals('107.50', $summaryBalanceInCurrencyEur);


        //------- test scenario 3 --------------

        $account->deposit($rubCurrency, '1000.00');
        $account->deposit($eurCurrency, '50.00');
        $account->deposit($usdCurrency, '10.00');


        // -------- test scenario 4 ---------------

        ($bank->getExchangeRate($eurCurrency, $rubCurrency))->setRate('150.00');

        ($bank->getExchangeRate($eurCurrency, $rubCurrency))->setRate('100.00');


        // -------- test scenario 5 ------------

        $summaryBalance = $account->getAccountSummaryBalance();

        $this->assertEquals('18789.00', $summaryBalance);


        // -------- test scenario 6 ----------------

        $account->setPrimaryCurrency($eurCurrency);

        $summaryBalanceInEuro = $account->getAccountSummaryBalance();

        $this->assertEquals('177.00', $summaryBalanceInEuro);


        // -------- test scenario 7 --------------

        // Конвертирует весь Рублёвый баланс в Евро (20 евро)
        $convertedEurFromRub = $account->getBalance($rubCurrency)->convertToCurrency($eurCurrency)->getAmount();

        // Вычетает полный рублевый баланс
        $account->withdraw($rubCurrency, $account->getBalance($rubCurrency)->getAmount());

        // Пополняем баланс сконвертированными Евро из Рубля
        $account->deposit($eurCurrency, $convertedEurFromRub);

        // Получаем сумму всех балансов в Основной валюте (ЕВРО)
        $summaryBalanceInEuro = $account->getAccountSummaryBalance();

        $this->assertEquals('177.00', $summaryBalanceInEuro);

        // ----------- test scenario 8 ------------


        ($bank->getExchangeRate($eurCurrency, $rubCurrency))->setRate('120.00');

        // ------------ test scenario 9 ------------

        // т.к рублевый баланс равен |0.00| изменение курса (евро к рублю) не повлеяло на суммарный баланс
        $summaryBalanceInEuro = $account->getAccountSummaryBalance($eurCurrency);

        $this->assertEquals('177.00', $summaryBalanceInEuro);


        // ------------- test scenario 10 ----------------

        $account->setPrimaryCurrency($rubCurrency);

        // Открепляет Валютные балансы,
        // перед этим конвертирует их в Основную валюту счёта
        // пополняет баланс в основной валюте на сконвертированную сумму
        // потом удаляет ненужные балансы
        $account->detachCurrency($eurCurrency);
        $account->detachCurrency($usdCurrency);

        $accountSupportedCurrencies = $account->getCurrencies();

        $this->assertEquals(['RUB' => $rubCurrency], $accountSupportedCurrencies);

        $summaryBalanceInRubles = $account->getAccountSummaryBalance();

        $this->assertEquals('21189.00', $summaryBalanceInRubles);

        $this->assertTrue(true);
    }
}
