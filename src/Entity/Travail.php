<?php

namespace App\Entity;

use App\Repository\TravailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: TravailRepository::class)]
class Travail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'date')]
    private $dateDebut = null;

    #[ORM\Column(type: 'date')]
    private $dateFin = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zone $zone = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypePeriode $periode = null;

    #[ORM\OneToMany(mappedBy: 'travail', targetEntity: TacheRealisee::class, cascade: ["persist"])]
    #[Valid]
    private Collection $tacheRealisees;

    public function __construct()
    {
        $this->tacheRealisees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    public function setDateDebut($dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin()
    {
        return $this->dateFin;
    }

    public function setDateFin($dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getPeriode(): ?TypePeriode
    {
        return $this->periode;
    }

    public function setPeriode(?TypePeriode $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * @return Collection<int, TacheRealisee>
     */
    public function getTacheRealisees(): Collection
    {
        return $this->tacheRealisees;
    }

    public function addTacheRealisee(TacheRealisee $tacheRealisee): self
    {
        if (!$this->tacheRealisees->contains($tacheRealisee)) {
            $this->tacheRealisees->add($tacheRealisee);
            $tacheRealisee->setTravail($this);
        }

        return $this;
    }

    public function removeTacheRealisee(TacheRealisee $tacheRealisee): self
    {
        if ($this->tacheRealisees->removeElement($tacheRealisee)) {
            // set the owning side to null (unless already changed)
            if ($tacheRealisee->getTravail() === $this) {
                $tacheRealisee->setTravail(null);
            }
        }

        return $this;
    }
}
