<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineBankRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineBankRepository::class)]
#[ORM\Table(name: '`exchange_rates`')]
class DoctrineExchangeRate
{

}