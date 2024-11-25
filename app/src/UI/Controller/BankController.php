<?php

namespace App\UI\Controller;

use App\Application\Command\Account\CreateAccountCommand;
use App\Application\CommandHandler\Account\CreateAccountCommandHandler;
use App\Application\QueryHandler\Account\GetUserAccountQueryHandler;
use App\UI\Request\AccountRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class BankController extends AbstractController
{
    public function __construct(
        private readonly CreateAccountCommandHandler $createAccountCommandHandler,
        //private readonly CreateAccountCommand $createAccountCommand,
        private readonly GetUserAccountQueryHandler $createAccountQueryHandler,
        //private readonly GetUserAccountQuery $accountQuery

    ){}

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
                primeCurrencyId: $accountRequestDTO->primeCurrencyId,
                currencyIds: $accountRequestDTO->currencyIds
            )
        );

        return $this->json(['Account successfully created'], 201);
    }

}