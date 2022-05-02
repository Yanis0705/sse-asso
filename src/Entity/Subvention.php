<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
use App\Repository\SubventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubventionRepository::class)]
class Subvention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateDemande;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montantOuQteDemande;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $commentaireDemandeur;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montantOuQteAttribues;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $commentaireAttributeur;

    #[ORM\ManyToOne(targetEntity: Association::class, inversedBy: 'subvention')]
    #[ORM\JoinColumn(nullable: false)]
    private $association;

    #[ORM\ManyToOne(targetEntity: TypeSubvention::class, inversedBy: 'subventions')]
    #[ORM\JoinColumn(nullable: false)]
    private $typeSubvention;

    #[ORM\ManyToOne(targetEntity: EtatSubvention::class, inversedBy: 'subventions')]
    private $etat;

    #[ORM\ManyToMany(targetEntity: Parametre::class, inversedBy: 'subventions')]
    private $parametres;

    public function __construct()
    {
        $this->parametres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): self
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getMontantOuQteDemande(): ?float
    {
        return $this->montantOuQteDemande;
    }

    public function setMontantOuQteDemande(float $montantOuQteDemande): self
    {
        $this->montantOuQteDemande = $montantOuQteDemande;

        return $this;
    }

    public function getCommentaireDemandeur(): ?string
    {
        return $this->commentaireDemandeur;
    }

    public function setCommentaireDemandeur(?string $commentaireDemandeur): self
    {
        $this->commentaireDemandeur = $commentaireDemandeur;

        return $this;
    }

    public function getMontantOuQteAttribues(): ?float
    {
        return $this->montantOuQteAttribues;
    }

    public function setMontantOuQteAttribues(?float $montantOuQteAttribues): self
    {
        $this->montantOuQteAttribues = $montantOuQteAttribues;

        return $this;
    }

    public function getCommentaireAttributeur(): ?string
    {
        return $this->commentaireAttributeur;
    }

    public function setCommentaireAttributeur(?string $commentaireAttributeur): self
    {
        $this->commentaireAttributeur = $commentaireAttributeur;

        return $this;
    }

    public function getAssociation(): ?Association
    {
        return $this->association;
    }

    public function setAssociation(?Association $association): self
    {
        $this->association = $association;

        return $this;
    }

    public function getTypeSubvention(): ?TypeSubvention
    {
        return $this->typeSubvention;
    }

    public function setTypeSubvention(?TypeSubvention $typeSubvention): self
    {
        $this->typeSubvention = $typeSubvention;

        return $this;
    }

    public function getTabTypeDemandeNature(): ?array
    {
        return $this->tabTypeDemandeNature;
    }

    public function setTabTypeDemandeNature(?array $tabTypeDemandeNature): self
    {
        $this->tabTypeDemandeNature = $tabTypeDemandeNature;

        return $this;
    }

    public function getEtat(): ?EtatSubvention
    {
        return $this->etat;
    }

    public function setEtat(?EtatSubvention $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCategorie(): ?TypeSubvention
    {
        return $this->categorie;
    }

    public function setCategorie(?TypeSubvention $categorie): self
    {
        $this->categorie = $categorie;

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
        }

        return $this;
    }

    public function removeParametre(Parametre $parametre): self
    {
        $this->parametres->removeElement($parametre);

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

}
