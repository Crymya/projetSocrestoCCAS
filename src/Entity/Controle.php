<?php

namespace App\Entity;

use App\Repository\ControleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ControleRepository::class)]
class Controle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Champ requis')]
    #[Assert\Length(min: 4, max: 255, minMessage: 'Minimum de 4 charactères requis', maxMessage: 'Maximum de 255 charactères requis')]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateControle = null;

    #[ORM\OneToMany(mappedBy: 'controle', targetEntity: Document::class, cascade: ["persist"])]
    private Collection $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
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

    public function getDateControle(): ?\DateTimeInterface
    {
        return $this->dateControle;
    }

    public function setDateControle(\DateTimeInterface $dateControle): self
    {
        $this->dateControle = $dateControle;

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
            $document->setControle($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getControle() === $this) {
                $document->setControle(null);
            }
        }

        return $this;
    }
}
