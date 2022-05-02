<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\AssociationRepository;
use App\Repository\BatimentRepository;
use App\Repository\StatutTicketRepository;
use App\Repository\TicketRepository;
use App\Repository\TypeTicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

#[Route('/ticket')]
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index', methods: ['GET', 'POST'])]
    public function index(  TicketRepository $ticketRepository,
                            TypeTicketRepository $typeTicketRepository,
                            AssociationRepository $associationRepository,
                            BatimentRepository $batimentRepository,
                            StatutTicketRepository $statutTicketRepository,
                            Request $request,
    ): Response
    {
        $filterTicket = $ticketRepository->findAll();

        $id = $request->query->get('id');

        if ($id != null){
            $paramDemandeurSelect = $id;
        }else {
            $paramDemandeurSelect =
                filter_input(INPUT_POST,'demandeurTicket-select',FILTER_SANITIZE_STRING);
        }
        $paramTypeTicketSelect =
            filter_input(INPUT_POST,'typeTicket-select',FILTER_SANITIZE_STRING);
        $paramBatimentSelect =
            filter_input(INPUT_POST,'batimentTicket-select',FILTER_SANITIZE_STRING);
        $paramStatutTicketSelect =
            filter_input(INPUT_POST,'statutTicket-select',FILTER_SANITIZE_STRING);

//        if ($paramTypeTicketSelect == null and $paramDemandeurSelect == null and
//            $paramBatimentSelect == null and $paramStatutTicketSelect == null) {
//            $filterTicket = $ticketRepository->findAll();
//        }

        if ($paramTypeTicketSelect == 'Tous'){$paramTypeTicketSelect = null;}
        if ($paramDemandeurSelect == 'Tous'){ $paramDemandeurSelect= null;}
        if ($paramBatimentSelect == 'Tous'){ $paramBatimentSelect = null;}
        if ($paramStatutTicketSelect == 'Tous'){ $paramStatutTicketSelect = null;}

        if ($paramTypeTicketSelect != null or $paramDemandeurSelect != null or
            $paramBatimentSelect != null or $paramStatutTicketSelect != null)
        {
            $filterTicket = $ticketRepository->findByFiltersTicket(
                $paramTypeTicketSelect, $paramDemandeurSelect, $paramBatimentSelect, $paramStatutTicketSelect
            );
        }

        return $this->render('ticket/index.html.twig', [
            'tickets' => $filterTicket,
            'typesTickets' => $typeTicketRepository->findAll(),
            'demandeurs' => $associationRepository->findAll(),
            'batiments' => $batimentRepository->findAll(),
            'statutsTickets' => $statutTicketRepository->findAll(),
            'typeTicketSelected' => $paramTypeTicketSelect,
            'demandeurSelected' => $paramDemandeurSelect,
            'batimentSelected' => $paramBatimentSelect,
            'statutSelected' => $paramStatutTicketSelect
        ]);
    }

    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketRepository->add($ticket);
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketRepository->add($ticket);
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $ticketRepository->remove($ticket);
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
