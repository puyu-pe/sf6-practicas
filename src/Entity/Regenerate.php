<?php

namespace App\Entity;

use App\Repository\RegenerateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegenerateRepository::class)]
class Regenerate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Customer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?string
    {
        return $this->Customer;
    }

    public function setCustomer(string $Customer): self
    {
        $this->Customer = $Customer;

        return $this;
    }
}
