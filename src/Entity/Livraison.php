<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\PositiveOrZero]
    private ?int $numeroLivraison = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\LessThan(propertyPath: 'dateConsommation', message: 'La date de livraison doit être antérieure à la date de consommation')]
    private ?\DateTimeInterface $dateLivraison = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan(propertyPath: 'dateLivraison', message: 'La date de consommation doit être supérieure à la date de livraison')]
    private ?\DateTimeInterface $dateConsommation = null;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Document::class, cascade: ["persist"])]
    private Collection $documents;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editeur $editeur = null;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroLivraison(): ?int
    {
        return $this->numeroLivraison;
    }

    public function setNumeroLivraison(int $numeroLivraison): self
    {
        $this->numeroLivraison = $numeroLivraison;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getDateConsommation(): ?\DateTimeInterface
    {
        return $this->dateConsommation;
    }

    public function setDateConsommation(\DateTimeInterface $dateConsommation): self
    {
        $this->dateConsommation = $dateConsommation;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setLivraison($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getLivraison() === $this) {
                $document->setLivraison(null);
            }
        }

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
