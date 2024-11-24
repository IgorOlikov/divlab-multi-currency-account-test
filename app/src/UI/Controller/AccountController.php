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

#[Route(path: 'api/v1')]
class AccountController extends AbstractController
{
    public function __construct(
        private readonly CreateAccountCommandHandler $createAccountCommandHandler,
        //private readonly CreateAccountCommand $createAccountCommand,
        private readonly GetUserAccountQueryHandler $createAccountQueryHandler,
        //private readonly GetUserAccountQuery $accountQuery

    ){}

    #[Route(path: '/account', methods: ['GET'])]
    public function indexAccounts()
    {
        //command get all user accounts
    }

    #[Route(path: '/account/{accountId}', requirements: ['accountId' => Requirement::UUID], methods: ['GET'])]
    public function showAccount(
        string $accountId
    )
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
                primeCurrencyId: $accountRequestDTO->primeCurrencyId
                )
            );

        return $this->json(['DoctrineAccount successfully created'], 201);
    }



}