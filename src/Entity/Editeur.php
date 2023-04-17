<?php

namespace App\Entity;

use App\Repository\EditeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EditeurRepository::class)]
class Editeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Minimum de 2 charactères requis', maxMessage: 'Maximum de 255 charactères requis')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Minimum de 2 charactères requis', maxMessage: 'Maximum de 255 charactères requis')]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\OneToMany(mappedBy: 'editeur', targetEntity: Temperature::class)]
    private Collection $temperatures;

    #[ORM\OneToMany(mappedBy: 'editeur', targetEntity: Etiquette::class, orphanRemoval: true)]
    private Collection $etiquettes;

    #[ORM\OneToMany(mappedBy: 'editeur', targetEntity: Livraison::class, orphanRemoval: true)]
    private Collection $livraisons;


    public function __construct()
    {
        $this->temperatures = new ArrayCollection();
        $this->etiquettes = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection<int, Temperature>
     */
    public function getTemperatures(): Collection
    {
        return $this->temperatures;
    }

    public function addTemperature(Temperature $temperature): self
    {
        if (!$this->temperatures->contains($temperature)) {
            $this->temperatures->add($temperature);
            $temperature->setEditeur($this);
        }

        return $this;
    }

    public function removeTemperature(Temperature $temperature): self
    {
        if ($this->temperatures->removeElement($temperature)) {
            // set the owning side to null (unless already changed)
            if ($temperature->getEditeur() === $this) {
                $temperature->setEditeur(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * @return Collection<int, Etiquette>
     */
    public function getEtiquettes(): Collection
    {
        return $this->etiquettes;
    }

    public function addEtiquette(Etiquette $etiquette): self
    {
        if (!$this->etiquettes->contains($etiquette)) {
            $this->etiquettes->add($etiquette);
            $etiquette->setEditeur($this);
        }

        return $this;
    }

    public function removeEtiquette(Etiquette $etiquette): self
    {
        if ($this->etiquettes->removeElement($etiquette)) {
            // set the owning side to null (unless already changed)
            if ($etiquette->getEditeur() === $this) {
                $etiquette->setEditeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons->add($livraison);
            $livraison->setEditeur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getEditeur() === $this) {
                $livraison->setEditeur(null);
            }
        }

        return $this;
    }

}
