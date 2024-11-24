<?php


namespace App\Domain\Entity;



use Symfony\Component\Uid\Uuid;


class DomainBank
{

    private ?Uuid $id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

}