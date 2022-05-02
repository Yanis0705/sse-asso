<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParametreRepository::class)]
class Parametre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $unite;

    #[ORM\Column(type: 'float', nullable: true)]
    private $valorisation;

    #[ORM\ManyToMany(targetEntity: Subvention::class, mappedBy: 'parametres')]
    private $subventions;

    #[ORM\ManyToOne(targetEntity: Parametrage::class, inversedBy: 'parametres')]
    private $parametrage;

    public function __construct()
    {
        $this->subventions = new ArrayCollection();
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

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getValorisation(): ?string
    {
        return $this->valorisation;
    }

    public function setValorisation(string $valorisation): self
    {
        $this->valorisation = $valorisation;

        return $this;
    }

    /**
     * @return Collection<int, Subvention>
     */
    public function getSubventions(): Collection
    {
        return $this->subventions;
    }

    public function addSubvention(Subvention $subvention): self
    {
        if (!$this->subventions->contains($subvention)) {
            $this->subventions[] = $subvention;
            $subvention->addParametre($this);
        }

        return $this;
    }

    public function removeSubvention(Subvention $subvention): self
    {
        if ($this->subventions->removeElement($subvention)) {
            $subvention->removeParametre($this);
        }

        return $this;
    }


    public function __toString()
    {
        return $this->nom;
    }

    public function getParametrage(): ?Parametrage
    {
        return $this->parametrage;
    }

    public function setParametrage(?Parametrage $parametrage): self
    {
        $this->parametrage = $parametrage;

        return $this;
    }
}
