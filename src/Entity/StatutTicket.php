<?php

namespace App\Entity;

use App\Repository\StatutTicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutTicketRepository::class)]
class StatutTicket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'statut', targetEntity: Ticket::class, cascade: ['persist', 'remove'])]
    private $ticket;

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

    public function __toString()
    {
        return $this->libelle;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): self
    {
        // set the owning side of the relation if necessary
        if ($ticket->getStatut() !== $this) {
            $ticket->setStatut($this);
        }

        $this->ticket = $ticket;

        return $this;
    }
}
