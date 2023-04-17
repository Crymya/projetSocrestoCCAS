<?php

namespace App\Entity;

use App\Repository\TacheRealiseeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: TacheRealiseeRepository::class)]
class TacheRealisee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $realisee = null;

    #[ORM\ManyToOne(inversedBy: 'tacheRealisees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Travail $travail = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tache $tache = null;

    #[ORM\ManyToOne]
    private ?Editeur $editeur = null;

    /**
     * @param bool|null $realisee
     */
    public function __construct()
    {
        $this->realisee = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isRealisee(): ?bool
    {
        return $this->realisee;
    }

    public function setRealisee(bool $realisee): self
    {
        $this->realisee = $realisee;

        return $this;
    }

    public function getTravail(): ?Travail
    {
        return $this->travail;
    }

    public function setTravail(?Travail $travail): self
    {
        $this->travail = $travail;

        return $this;
    }

    public function getTache(): ?Tache
    {
        return $this->tache;
    }

    public function setTache(?Tache $tache): self
    {
        $this->tache = $tache;

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

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        if ($this->isRealisee() && !$this->editeur)
        {
            $context->buildViolation('L\'utilisateur est obligatoire pour une tâche réalisée !')
                ->atPath('editeur')
                ->addViolation();
        }
    }

}
