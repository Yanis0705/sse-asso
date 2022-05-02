<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255)]
    private $idClicko;

    #[ORM\Column(type: 'string', length: 255)]
    private $idGST;

    #[ORM\ManyToOne(targetEntity: Association::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private $demandeur;

    #[ORM\ManyToOne(targetEntity: TypeTicket::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $idTypeTicket;

    #[ORM\ManyToOne(targetEntity: StatutTicket::class, inversedBy: 'ticket')]
    #[ORM\JoinColumn(nullable: false)]
    private $statut;

    #[ORM\ManyToOne(targetEntity: Batiment::class, inversedBy: 'tickets')]
    private $batiment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getBatiment(): ?Batiment
    {
        return $this->batiment;
    }

    public function setBatiment(?Batiment $batiment): self
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function getIdClicko(): ?string
    {
        return $this->idClicko;
    }

    public function setIdClicko(string $idClicko): self
    {
        $this->idClicko = $idClicko;

        return $this;
    }

    public function getIdGST(): ?string
    {
        return $this->idGST;
    }

    public function setIdGST(string $idGST): self
    {
        $this->idGST = $idGST;

        return $this;
    }

    public function getDemandeur(): ?Association
    {
        return $this->demandeur;
    }

    public function setDemandeur(?Association $demandeur): self
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    public function getIdTypeTicket(): ?TypeTicket
    {
        return $this->idTypeTicket;
    }

    public function setIdTypeTicket(TypeTicket $idTypeTicket): self
    {
        $this->idTypeTicket = $idTypeTicket;

        return $this;
    }

    public function getStatut(): ?StatutTicket
    {
        return $this->statut;
    }

    public function setStatut(StatutTicket $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
