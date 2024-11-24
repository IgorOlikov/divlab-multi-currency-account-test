<?php

namespace App\Application\CommandHandler;

use App\Application\Command\CommandInterface;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): mixed;
}