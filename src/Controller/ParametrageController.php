<?php

namespace App\Controller;

use App\Entity\Parametrage;
use App\Form\ParametrageType;
use App\Repository\ParametrageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parametrage')]
class ParametrageController extends AbstractController
{
    #[Route('/', name: 'app_parametrage_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ParametrageRepository $parametrageRepository): Response
    {
        $parametrage = new Parametrage();
        $form = $this->createForm(ParametrageType::class, $parametrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametrageRepository->add($parametrage);
            return $this->redirectToRoute('app_parametrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametrage/index.html.twig', [
            'parametrages' => $parametrageRepository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_parametrage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParametrageRepository $parametrageRepository): Response
    {
        $parametrage = new Parametrage();
        $form = $this->createForm(ParametrageType::class, $parametrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametrageRepository->add($parametrage);
            return $this->redirectToRoute('app_parametrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametrage/new.html.twig', [
            'parametrage' => $parametrage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parametrage_edit', methods: ['GET', 'POST'])]
    public function edit(Parametrage $parametrage, ParametrageRepository $parametrageRepository): Response
    {

        $paramLibelle = filter_input(INPUT_POST, 'libelle-param', FILTER_SANITIZE_STRING);
        $paramValeurFloat = filter_input(INPUT_POST, 'valeur-param', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
//        $paramValeur = filter_input(INPUT_POST, 'valeur-param', FILTER_SANITIZE_STRING);
//        $paramValeurFloat = floatval( $paramValeur );
        $paramLibelleValeur = filter_input(INPUT_POST, 'libelle-valeur-param', FILTER_SANITIZE_STRING);

        $parametrage->setLibelle($paramLibelle);
        $parametrage->setValeur($paramValeurFloat);
        $parametrage->setValeurLabel($paramLibelleValeur);

        $parametrageRepository->add($parametrage);

            return $this->redirectToRoute('app_parametrage_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_parametrage_delete', methods: ['POST'])]
    public function delete(Request $request, Parametrage $parametrage, ParametrageRepository $parametrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parametrage->getId(), $request->request->get('_token'))) {
            $parametrageRepository->remove($parametrage);
        }

        return $this->redirectToRoute('app_parametrage_index', [], Response::HTTP_SEE_OTHER);
    }

}
