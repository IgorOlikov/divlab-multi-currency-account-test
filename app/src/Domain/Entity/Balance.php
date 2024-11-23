<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineBalanceRepository;

#[ORM\Entity(repositoryClass: DoctrineBalanceRepository::class)]
class Balance
{

}