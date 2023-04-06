<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomStockage = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etiquette $etiquette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStockage(): ?string
    {
        return $this->nomStockage;
    }

    public function setNomStockage(string $nomStockage): self
    {
        $this->nomStockage = $nomStockage;

        return $this;
    }

    public function getEtiquette(): ?Etiquette
    {
        return $this->etiquette;
    }

    public function setEtiquette(?Etiquette $etiquette): self
    {
        $this->etiquette = $etiquette;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomStockage;
    }


}
