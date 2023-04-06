<?php

namespace App\Entity;

use App\Repository\EtiquetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtiquetteRepository::class)]
class Etiquette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomProduit = null;

    #[ORM\Column]
    private ?float $temperature = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $jourUtilise = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dlc = null;

    #[ORM\OneToMany(mappedBy: 'etiquette', targetEntity: Document::class, cascade: ["persist"], orphanRemoval: true)]
    private Collection $documents;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'etiquettes')]
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

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getJourUtilise(): ?\DateTimeInterface
    {
        return $this->jourUtilise;
    }

    public function setJourUtilise(\DateTimeInterface $jourUtilise): self
    {
        $this->jourUtilise = $jourUtilise;

        return $this;
    }

    public function getDlc(): ?\DateTimeInterface
    {
        return $this->dlc;
    }

    public function setDlc(\DateTimeInterface $dlc): self
    {
        $this->dlc = $dlc;

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
            $document->setEtiquette($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getEtiquette() === $this) {
                $document->setEtiquette(null);
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
