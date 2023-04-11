<?php

namespace App\Entity;

use App\Repository\TemperatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TemperatureRepository::class)]
class Temperature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\Range(notInRangeMessage: 'Merci de saisir une valeur entre {{ min}} et {{ max }}', min: -30, max: 10)]
    private ?float $valeur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\DateTime]
    private ?\DateTimeInterface $dateControle = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'temperatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $materiel = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'temperatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editeur $editeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getDateControle(): ?\DateTimeInterface
    {
        return $this->dateControle;
    }

    public function setDateControle(\DateTimeInterface $dateControle): self
    {
        $this->dateControle = $dateControle;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }
}
