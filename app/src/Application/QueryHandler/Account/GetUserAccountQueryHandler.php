<?php

namespace App\Application\QueryHandler\Account;

use App\Application\Query\QueryInterface;
use App\Application\QueryHandler\QueryHandlerInterface;

class GetUserAccountQueryHandler implements QueryHandlerInterface
{

    public function handle(QueryInterface $command): mixed
    {
        dd($command);
    }
}