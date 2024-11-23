<?php

namespace App\Application\UseCase;

class CreateAccountUseCase
{
    private CreateAccountHandler $createAccountHandler;

    public function __construct(CreateAccountHandler $createAccountHandler)
    {
        $this->createAccountHandler = $createAccountHandler;
    }

    public function execute(CreateAccountCommand $command)
    {
        return $this->createAccountHandler->handle($command);
    }
}