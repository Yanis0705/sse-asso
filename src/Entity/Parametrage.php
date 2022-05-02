<?php

namespace App\Entity;

use App\Repository\ParametrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParametrageRepository::class)]
class Parametrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\Column(type: 'float')]
    private $valeur;

    #[ORM\OneToMany(mappedBy: 'categorieSubNature', targetEntity: TypeSubvention::class)]
    private $typeSubventions;

    #[ORM\Column(type: 'string', length: 20)]
    private $valeurLabel;

    #[ORM\OneToMany(mappedBy: 'parametrage', targetEntity: Parametre::class)]
    private $parametres;

    public function __construct()
    {
        $this->typeSubventions = new ArrayCollection();
        $this->parametres = new ArrayCollection();
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

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * @return Collection<int, TypeSubvention>
     */
    public function getTypeSubventions(): Collection
    {
        return $this->typeSubventions;
    }

    public function addTypeSubvention(TypeSubvention $typeSubvention): self
    {
        if (!$this->typeSubventions->contains($typeSubvention)) {
            $this->typeSubventions[] = $typeSubvention;
        }

        return $this;
    }

    public function removeTypeSubvention(TypeSubvention $typeSubvention): self
    {
        if ($this->typeSubventions->removeElement($typeSubvention)) {
            // set the owning side to null (unless already changed)
            if ($typeSubvention->getCategorieSubNature() === $this) {
                $typeSubvention->setCategorieSubNature(null);
            }
        }

        return $this;
    }


    public function getValeurLabel(): ?string
    {
        return $this->valeurLabel;
    }

    public function setValeurLabel(string $valeurLabel): self
    {
        $this->valeurLabel = $valeurLabel;

        return $this;
    }

    /**
     * @return Collection<int, Parametre>
     */
    public function getParametres(): Collection
    {
        return $this->parametres;
    }

    public function addParametre(Parametre $parametre): self
    {
        if (!$this->parametres->contains($parametre)) {
            $this->parametres[] = $parametre;
            $parametre->setParametrage($this);
        }

        return $this;
    }

    public function removeParametre(Parametre $parametre): self
    {
        if ($this->parametres->removeElement($parametre)) {
            // set the owning side to null (unless already changed)
            if ($parametre->getParametrage() === $this) {
                $parametre->setParametrage(null);
            }
        }

        return $this;
    }

}
