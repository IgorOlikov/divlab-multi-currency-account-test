<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineBankRepository::class)]
class ExchangeRate
{

}