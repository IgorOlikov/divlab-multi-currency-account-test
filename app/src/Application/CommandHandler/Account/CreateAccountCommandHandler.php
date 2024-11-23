<?php

namespace App\Application\Handler\Account;

use App\Application\Handler\CommandHandlerInterface;

class CreateAccountCommandHandler implements CommandHandlerInterface
{
    private AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function handle(CreateAccountCommand $command)
    {
        return $this->accountService->createAccount(
            $command->getUserId(),
            $command->getBankId(),
            $command->getCurrency(),
            $command->getBalance()
        );
    }
}