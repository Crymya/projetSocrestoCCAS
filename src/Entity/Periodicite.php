<?php

namespace App\Entity;

use App\Repository\PeriodiciteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodiciteRepository::class)]
class Periodicite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $periode = null;

    #[ORM\Column]
    private ?int $recurrence = null;

    #[ORM\OneToMany(mappedBy: 'periodicite', targetEntity: ListeDesTaches::class, cascade: ["persist"])]
    private Collection $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(string $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getRecurrence(): ?int
    {
        return $this->recurrence;
    }

    public function setRecurrence(int $recurrence): self
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * @return Collection<int, ListeDesTaches>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(ListeDesTaches $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setPeriodicite($this);
        }

        return $this;
    }

    public function removeTach(ListeDesTaches $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getPeriodicite() === $this) {
                $tach->setPeriodicite(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->description;
    }


}
