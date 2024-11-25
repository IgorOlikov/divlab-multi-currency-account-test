<?php

namespace App\UI\Controller;

use App\Application\Command\Account\CreateAccountCommand;
use App\Application\CommandHandler\Account\CreateAccountCommandHandler;
use App\Application\Query\Account\GetUserAccountQuery;
use App\Application\QueryHandler\Account\GetUserAccountQueryHandler;
use App\UI\Request\AccountRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(path: 'api/v1/account')]
class AccountController extends AbstractController
{
    public function __construct(
        private readonly CreateAccountCommandHandler $createAccountCommandHandler,
        //private readonly CreateAccountCommand $createAccountCommand,
        private readonly GetUserAccountQueryHandler $createAccountQueryHandler,
        //private readonly GetUserAccountQuery $accountQuery

    ){}

    #[Route(path: '/', methods: ['GET'])]
    public function indexAccounts()
    {
        //command get all user accounts
        //$this->getUser()->getUserIdentifier()

    }

    #[Route(path: '/{accountId}', requirements: ['accountId' => Requirement::UUID], methods: ['GET'])]
    public function showAccount(
        string $accountId
    )
    {
        //command get account by id
    }

    public function deposit()
    {
        // user id
        //account id
        // currency id
        // amount
    }

    public function getSummaryAccountBalance()
    {
        // user id
        // account id
        // NULLABLE currencyId (get summary in current prime currency (null) or specific (currencyId))
    }

    public function setPrimeCurrency()
    {
        // user id
        // accountId
        // currency id
    }

    public function convertCurrencyBalanceToAnother()
    {
        // перевод
        // user id
        // account id
        //  from currency
        // to currency
        // amount
    }



}