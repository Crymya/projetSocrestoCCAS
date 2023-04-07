<?php

namespace App\Entity;

use App\Repository\TacheRealiseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRealiseRepository::class)]
class TacheRealise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $moment = null;

    #[ORM\ManyToOne(inversedBy: 'tacheRealises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editeur $editeur = null;

    #[ORM\ManyToOne(inversedBy: 'tacheRealises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ListeDesTaches $tache = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoment(): ?\DateTimeInterface
    {
        return $this->moment;
    }

    public function setMoment(\DateTimeInterface $moment): self
    {
        $this->moment = $moment;

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

    public function getTache(): ?ListeDesTaches
    {
        return $this->tache;
    }

    public function setTache(?ListeDesTaches $tache): self
    {
        $this->tache = $tache;

        return $this;
    }
}
