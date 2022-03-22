<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomDetaille;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $info;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lienFacebook;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lienTwitter;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lienInstagram;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomPresident;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenomPresident;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $emailPresident;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephonePresident;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomSecretaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenomSecretaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $emailSecretaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephoneSecretaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomTresorier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenomTresorier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $emailTresorier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephoneTresorier;

    #[ORM\ManyToOne(inversedBy: 'association', targetEntity: Categorie::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

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

    public function getNomDetaille(): ?string
    {
        return $this->nomDetaille;
    }

    public function setNomDetaille(string $nomDetaille): self
    {
        $this->nomDetaille = $nomDetaille;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLienFacebook(): ?string
    {
        return $this->lienFacebook;
    }

    public function setLienFacebook(?string $lienFacebook): self
    {
        $this->lienFacebook = $lienFacebook;

        return $this;
    }

    public function getLienTwitter(): ?string
    {
        return $this->lienTwitter;
    }

    public function setLienTwitter(?string $lienTwitter): self
    {
        $this->lienTwitter = $lienTwitter;

        return $this;
    }

    public function getLienInstagram(): ?string
    {
        return $this->lienInstagram;
    }

    public function setLienInstagram(?string $lienInstagram): self
    {
        $this->lienInstagram = $lienInstagram;

        return $this;
    }

    public function getNomPresident(): ?string
    {
        return $this->nomPresident;
    }

    public function setNomPresident(string $nomPresident): self
    {
        $this->nomPresident = $nomPresident;

        return $this;
    }

    public function getPrenomPresident(): ?string
    {
        return $this->prenomPresident;
    }

    public function setPrenomPresident(string $prenomPresident): self
    {
        $this->prenomPresident = $prenomPresident;

        return $this;
    }

    public function getEmailPresident(): ?string
    {
        return $this->emailPresident;
    }

    public function setEmailPresident(string $emailPresident): self
    {
        $this->emailPresident = $emailPresident;

        return $this;
    }

    public function getTelephonePresident(): ?string
    {
        return $this->telephonePresident;
    }

    public function setTelephonePresident(string $telephonePresident): self
    {
        $this->telephonePresident = $telephonePresident;

        return $this;
    }

    public function getNomSecretaire(): ?string
    {
        return $this->nomSecretaire;
    }

    public function setNomSecretaire(string $nomSecretaire): self
    {
        $this->nomSecretaire = $nomSecretaire;

        return $this;
    }

    public function getPrenomSecretaire(): ?string
    {
        return $this->prenomSecretaire;
    }

    public function setPrenomSecretaire(string $prenomSecretaire): self
    {
        $this->prenomSecretaire = $prenomSecretaire;

        return $this;
    }

    public function getEmailSecretaire(): ?string
    {
        return $this->emailSecretaire;
    }

    public function setEmailSecretaire(string $emailSecretaire): self
    {
        $this->emailSecretaire = $emailSecretaire;

        return $this;
    }

    public function getTelephoneSecretaire(): ?string
    {
        return $this->telephoneSecretaire;
    }

    public function setTelephoneSecretaire(string $telephoneSecretaire): self
    {
        $this->telephoneSecretaire = $telephoneSecretaire;

        return $this;
    }

    public function getNomTresorier(): ?string
    {
        return $this->nomTresorier;
    }

    public function setNomTresorier(string $nomTresorier): self
    {
        $this->nomTresorier = $nomTresorier;

        return $this;
    }

    public function getPrenomTresorier(): ?string
    {
        return $this->prenomTresorier;
    }

    public function setPrenomTresorier(string $prenomTresorier): self
    {
        $this->prenomTresorier = $prenomTresorier;

        return $this;
    }

    public function getEmailTresorier(): ?string
    {
        return $this->emailTresorier;
    }

    public function setEmailTresorier(string $emailTresorier): self
    {
        $this->emailTresorier = $emailTresorier;

        return $this;
    }

    public function getTelephoneTresorier(): ?string
    {
        return $this->telephoneTresorier;
    }

    public function setTelephoneTresorier(string $telephoneTresorier): self
    {
        $this->telephoneTresorier = $telephoneTresorier;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
