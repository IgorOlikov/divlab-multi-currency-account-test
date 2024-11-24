<?php

namespace App\Application\CommandHandler\Account;


use App\Application\Command\Account\CreateAccountCommand;
use App\Application\Command\CommandInterface;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Application\Service\AccountService;



readonly class CreateAccountCommandHandler implements CommandHandlerInterface
{

    public function __construct(
        private AccountService $accountService
    )
    {}


    /**
     * @param CreateAccountCommand $command
     * @return mixed
     */
    public function handle(CommandInterface $command): mixed
    {
        return $this->accountService->createAccount(
            $command->getUserId(),
            $command->getBankId(),
            $command->getPrimeCurrencyId(),
        );
    }
}