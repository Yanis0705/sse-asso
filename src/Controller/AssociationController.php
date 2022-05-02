<?php

namespace App\Controller;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Repository\AssociationRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/association')]
class AssociationController extends AbstractController
{
    #[Route('/', name: 'app_association_index', methods: ['GET', 'POST'])]
    public function index(  AssociationRepository $associationRepository,
                            CategorieRepository $categorieRepository,
                            Request $request
): Response
    {
        $terme = filter_input(INPUT_POST, 'terme', FILTER_SANITIZE_STRING);
        $paramCat1 = filter_input(INPUT_POST, 'cat1', FILTER_SANITIZE_STRING);
        $paramCat2 = filter_input(INPUT_POST, 'cat2', FILTER_SANITIZE_STRING);
        $paramCat3 = filter_input(INPUT_POST, 'cat3', FILTER_SANITIZE_STRING);
        $paramCat4 = filter_input(INPUT_POST, 'cat4', FILTER_SANITIZE_STRING);
        $paramCat5 = filter_input(INPUT_POST, 'cat5', FILTER_SANITIZE_STRING);
        $paramCat6 = filter_input(INPUT_POST, 'cat6', FILTER_SANITIZE_STRING);
        $paramCat7 = filter_input(INPUT_POST, 'cat7', FILTER_SANITIZE_STRING);

       // On récupère les associations de la page en fonction du filtre
        $associations = $associationRepository->findByFilters(
            $terme, $paramCat1, $paramCat2, $paramCat3, $paramCat4, $paramCat5, $paramCat6, $paramCat7);

        $categories = $categorieRepository->findAll();
        return $this->render('association/index.html.twig', [
            'associations' => $associations,
            'categories' => $categories,
            'paramCat1' => $paramCat1,
            'paramCat2' => $paramCat2,
            'paramCat3' => $paramCat3,
            'paramCat4' => $paramCat4,
            'paramCat5' => $paramCat5,
            'paramCat6' => $paramCat6,
            'paramCat7' => $paramCat7,
        ]);
    }

    #[Route('/new', name: 'app_association_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AssociationRepository $associationRepository): Response
    {
        $association = new Association();
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associationRepository->add($association);
            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('association/new.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_association_show', methods: ['GET'])]
    public function show(Association $association): Response
    {
        return $this->render('association/show.html.twig', [
            'association' => $association,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_association_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Association $association, AssociationRepository $associationRepository): Response
    {
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associationRepository->add($association);
            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('association/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_association_delete', methods: ['POST'])]
    public function delete(Request $request, Association $association, AssociationRepository $associationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$association->getId(), $request->request->get('_token'))) {
            $associationRepository->remove($association);
        }

        return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
    }
}
