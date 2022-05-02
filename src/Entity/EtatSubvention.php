<?php

namespace App\Entity;

use App\Repository\EtatSubventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatSubventionRepository::class)]
class EtatSubvention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Subvention::class)]
    private $subventions;

    public function __construct()
    {
        $this->subventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $subvention->setEtat($this);
        }

        return $this;
    }

    public function removeSubvention(Subvention $subvention): self
    {
        if ($this->subventions->removeElement($subvention)) {
            // set the owning side to null (unless already changed)
            if ($subvention->getEtat() === $this) {
                $subvention->setEtat(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->libelle;
    }
}
