<?php

namespace App\Entity;

use App\Repository\IncidentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncidentRepository::class)]
class Incident
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $temp = null;

    #[ORM\Column(nullable: true)]
    private ?int $humedite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemp(): ?int
    {
        return $this->temp;
    }

    public function setTemp(?int $temp): static
    {
        $this->temp = $temp;

        return $this;
    }

    public function getHumedite(): ?int
    {
        return $this->humedite;
    }

    public function setHumedite(?int $humedite): static
    {
        $this->humedite = $humedite;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(?\DateTimeInterface $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }
}
