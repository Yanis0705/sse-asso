<?php

namespace App\Entity;

use App\Repository\TypeSubventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeSubventionRepository::class)]
class TypeSubvention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\Column(type: 'string', length: 255)]
    public $categorie;

    #[ORM\OneToMany(mappedBy: 'typeSubvention', targetEntity: Subvention::class)]
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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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
            $subvention->setTypeSubvention($this);
        }

        return $this;
    }

    public function removeSubvention(Subvention $subvention): self
    {
        if ($this->subventions->removeElement($subvention)) {
            // set the owning side to null (unless already changed)
            if ($subvention->getTypeSubvention() === $this) {
                $subvention->setTypeSubvention(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * @return Collection<int, Subvention>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Subvention $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCategorie($this);
        }

        return $this;
    }

    public function removeCategory(Subvention $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCategorie() === $this) {
                $category->setCategorie(null);
            }
        }

        return $this;
    }

}
