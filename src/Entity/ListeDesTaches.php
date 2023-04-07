<?php

namespace App\Entity;

use App\Repository\ListeDesTachesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeDesTachesRepository::class)]
class ListeDesTaches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'tache', targetEntity: TacheRealise::class)]
    private Collection $tacheRealises;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $lieu = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Periodicite $periodicite = null;

    public function __construct()
    {
        $this->tacheRealises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, TacheRealise>
     */
    public function getTacheRealises(): Collection
    {
        return $this->tacheRealises;
    }

    public function addTacheRealise(TacheRealise $tacheRealise): self
    {
        if (!$this->tacheRealises->contains($tacheRealise)) {
            $this->tacheRealises->add($tacheRealise);
            $tacheRealise->setTache($this);
        }

        return $this;
    }

    public function removeTacheRealise(TacheRealise $tacheRealise): self
    {
        if ($this->tacheRealises->removeElement($tacheRealise)) {
            // set the owning side to null (unless already changed)
            if ($tacheRealise->getTache() === $this) {
                $tacheRealise->setTache(null);
            }
        }

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getPeriodicite(): ?Periodicite
    {
        return $this->periodicite;
    }

    public function setPeriodicite(?Periodicite $periodicite): self
    {
        $this->periodicite = $periodicite;

        return $this;
    }
}
