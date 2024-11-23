<?php

namespace App\UI\Controller;

use App\Application\Command\Account\CreateAccountCommand;
use App\Application\Handler\Account\CreateAccountCommandHandler;
use App\Application\Query\Account\GetUserAccountQuery;
use App\Application\QueryHandler\Account\GetUserAccountQueryHandler;
use App\UI\Request\AccountRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'api/v1')]
class AccountController extends AbstractController
{
    public function __construct(
        private readonly CreateAccountCommandHandler $createAccountCommandHandler,
        private readonly CreateAccountCommand $createAccountCommand,
        private readonly GetUserAccountQueryHandler $createAccountQueryHandler,
        private readonly GetUserAccountQuery $accountQuery

    ){}

    #[Route(path: '/account', methods: ['GET'])]
    public function indexAccounts()
    {
        //command get all user accounts
    }

    #[Route(path: '/account/{accountId}', methods: ['GET'])]
    public function showAccount()
    {
        //command get account by id
    }

    #[Route(path: '/create-account', methods: ['POST'])]
    public function createAccount(
        #[MapRequestPayload(acceptFormat: 'json', validationGroups: ['createAccount'])]
        AccountRequestDTO $accountRequestDTO
    ): Response
    {
        $this->createAccountCommandHandler->handle(
            new CreateAccountCommand(
                userId: $this->getUser()->getUserIdentifier(),
                bankId: $accountRequestDTO->bankId,
                currencyId: $accountRequestDTO->primeCurrencyId
                )
            );

        return $this->json(['Account successfully created'], 201);
    }



}