<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Minimum de 2 charactères requis', maxMessage: 'Maximum de 255 charactères requis')]
    private ?string $nomStockage = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'documents')]
    private ?Etiquette $etiquette = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'documents')]
    private ?Livraison $livraison = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    private ?Controle $controle = null;

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getControle(): ?Controle
    {
        return $this->controle;
    }

    public function setControle(?Controle $controle): self
    {
        $this->controle = $controle;

        return $this;
    }


}
