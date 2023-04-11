<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\Length(min: 4, max: 255, minMessage: 'Minimum de 4 charactères requis', maxMessage: 'Maximum de 255 charactères requis')]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\Range(notInRangeMessage: 'Merci de saisir une valeur entre {{ min}} et {{ max }}', min: -30, max: 10)]
    private ?int $tempMax = null;

    #[ORM\OneToMany(mappedBy: 'materiel', targetEntity: Temperature::class, cascade: ["persist"])]
    private Collection $temperatures;

    public function __construct()
    {
        $this->temperatures = new ArrayCollection();
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

    public function getTempMax(): ?int
    {
        return $this->tempMax;
    }

    public function setTempMax(int $tempMax): self
    {
        $this->tempMax = $tempMax;

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
            $temperature->setMateriel($this);
        }

        return $this;
    }

    public function removeTemperature(Temperature $temperature): self
    {
        if ($this->temperatures->removeElement($temperature)) {
            // set the owning side to null (unless already changed)
            if ($temperature->getMateriel() === $this) {
                $temperature->setMateriel(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }


}
