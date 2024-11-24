<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineBalanceRepository;

#[ORM\Entity(repositoryClass: DoctrineBalanceRepository::class)]
#[ORM\Table(name: '`balances`')]
class DoctrineBalance
{

}