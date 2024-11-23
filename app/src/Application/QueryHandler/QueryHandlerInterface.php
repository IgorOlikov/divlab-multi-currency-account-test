<?php

namespace App\Application\QueryHandler;

use App\Application\Query\QueryInterface;

interface QueryHandlerInterface
{
    public function handle(QueryInterface $command): mixed;
}