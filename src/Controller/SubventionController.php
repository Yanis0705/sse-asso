<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\Subvention;
use App\Form\SubventionType;
use App\Repository\AssociationRepository;
use App\Repository\EtatSubventionRepository;
use App\Repository\ParametreRepository;
use App\Repository\ParametrageRepository;
use App\Repository\SubventionRepository;
use App\Repository\TypeSubventionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subvention')]
class SubventionController extends AbstractController
{
    #[Route('/', name: 'app_subvention_index', methods: ['GET', 'POST'])]
    public function index(SubventionRepository $subventionRepository,
                          TypeSubventionRepository $typeSubventionRepository,
                          AssociationRepository $associationRepository,
                          EtatSubventionRepository $etatSubventionRepository,
                          ParametreRepository $parametreRepository,
                          Request $request,
    ): Response
    {
        $filterSubvention = $subventionRepository->findAll();

        $id = $request->query->get('id');

        if ($id != null){
            $paramAssociationSelect = $id;
        }else {
            $paramAssociationSelect = filter_input(INPUT_POST,'associationSubvention-select',FILTER_SANITIZE_STRING);
        }
        $paramEtatSubventionSelect = filter_input(INPUT_POST,'etatSubventions-select',FILTER_SANITIZE_STRING);
        $paramSubFonctionnements = filter_input(INPUT_POST,'subFonctionnements',FILTER_SANITIZE_STRING);
        $paramSubEquipements = filter_input(INPUT_POST,'subEquipements',FILTER_SANITIZE_STRING);
        $paramSubExceptionnelles = filter_input(INPUT_POST,'subExceptionnelles',FILTER_SANITIZE_STRING);
        $paramSubNatures = filter_input(INPUT_POST,'subNatures',FILTER_SANITIZE_STRING);
        $choixDateStart = filter_input(INPUT_POST, 'date-ticket-start', FILTER_SANITIZE_STRING);
        $choixDateEnd = filter_input(INPUT_POST, 'date-ticket-end', FILTER_SANITIZE_STRING);

        if ($paramAssociationSelect == 'Tous'){$paramAssociationSelect = null;}
        if ($paramEtatSubventionSelect == 'Tous'){ $paramEtatSubventionSelect = null;}


        if ($paramAssociationSelect != null or $paramEtatSubventionSelect != null
            or $paramSubFonctionnements != null or $paramSubEquipements != null
            or $paramSubExceptionnelles != null  or $paramSubNatures != null
            or ($choixDateStart != null and $choixDateEnd != null)
        )
        {
            $filterSubvention = $subventionRepository->findByFiltersSubvention(
                $paramAssociationSelect, $paramEtatSubventionSelect, $paramSubFonctionnements, $paramSubEquipements,
                $paramSubExceptionnelles, $paramSubNatures, $choixDateStart, $choixDateEnd);
        }

        if ((($choixDateStart != null) and ($choixDateEnd == null)) or (($choixDateEnd != null) and $choixDateStart == null)) {
            $this->addFlash('error', 'Veuillez sélectionner les deux dates');
            $filterSubvention = $subventionRepository->findAll();

        }

        return $this->render('subvention/index.html.twig', [
            'subventions' => $filterSubvention,
            'etatSubventions' => $etatSubventionRepository->findAll(),
            'associations' => $associationRepository->findAll(),
            'typesSubventions' => $typeSubventionRepository->findAll(),
            'parametres' => $parametreRepository->findAll(),
            'associationSelected' => $paramAssociationSelect,
            'etatSubventionSelected' => $paramEtatSubventionSelect,
            'paramSubFonctionnements' => $paramSubFonctionnements,
            'paramSubEquipements' => $paramSubEquipements,
            'paramSubExceptionnelles' => $paramSubExceptionnelles,
            'paramSubNatures' => $paramSubNatures,
            "choixDateStart" => $choixDateStart,
            "choixDateEnd" => $choixDateEnd,
        ]);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/new', name: 'app_subvention_new', methods: ['GET', 'POST'])]
    public function new(Request $request,
                        EntityManagerInterface $em,
                        SubventionRepository $subventionRepository,
                        TypeSubventionRepository $typeSubventionRepository,
                        ParametreRepository $parametreRepository,
                        ParametrageRepository $parametrageRepository,
                        EtatSubventionRepository $etatSubventionRepository
    ): Response
    {

        $subvention = new Subvention();
        $etatSubventionDefaut = $etatSubventionRepository->find(['id' => 2]);
        $subvention->setEtat($etatSubventionDefaut);
        $typesubvention = filter_input(INPUT_POST, 'type-subvention-select', FILTER_SANITIZE_STRING);
        $subvention->setTypeSubvention($typesubvention);

        $form = $this->createForm(SubventionType::class, $subvention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $compteurParam = filter_input(INPUT_POST, 'compteur-param', FILTER_SANITIZE_NUMBER_INT);

            for ($i=0; $i<=$compteurParam; $i++){

                $typeNatureParam = filter_input(INPUT_POST, 'parametrage-select'.$i, FILTER_SANITIZE_NUMBER_INT);
                $nameParam = filter_input(INPUT_POST, 'name-param'.$i, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                $uniteParam = filter_input(INPUT_POST, 'unite-param'.$i, FILTER_SANITIZE_STRING);
                $valorisationParam = filter_input(INPUT_POST, 'valorisation-param'.$i, FILTER_SANITIZE_NUMBER_INT);

                if ($nameParam != null and $uniteParam != null and $valorisationParam != null){

                    $parametre = new Parametre();

                    $typeNatureInstance = $parametrageRepository->find($typeNatureParam);
                    $parametre->setParametrage($typeNatureInstance);
                    $parametre->setNom($nameParam);
                    $parametre->setUnite($uniteParam);
                    $parametre->setValorisation($valorisationParam);

                    $subvention->addParametre($parametre);
                    $em->persist($parametre);
                    $em->flush($parametre);
                }
            }

            $em->persist($subvention);
            $em->flush($subvention);
            return $this->redirectToRoute('app_subvention_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('subvention/new.html.twig', [
            'subvention' => $subvention,
            'form' => $form,
            'subventions' => $subventionRepository->findAll(),
            'typesSubventions' => $typeSubventionRepository->findAll(),
            'parametres' => $parametreRepository->findAll(),
            'parametrages' => $parametrageRepository->findAll(),
        ]);
    }

    #[Route('/{id}/attribution', name: 'app_subvention_attribution', methods: ['GET', 'POST'])]
    public function attribution(Subvention $subvention,
                                SubventionRepository $subventionRepository,
                                AssociationRepository $associationRepository,
                                EtatSubventionRepository $etatSubventionRepository,
                                EntityManagerInterface $em): Response
    {
        $montantAttribueParam = filter_input(INPUT_POST, 'montant-a-attribuer', FILTER_SANITIZE_NUMBER_INT);
        $commentaireAttributeurParam = filter_input(INPUT_POST, 'commentaire-attrib', FILTER_SANITIZE_STRING);
        $etatCheckboxRefus = filter_input(INPUT_POST, 'refus-subv', FILTER_SANITIZE_STRING);

        if ($etatCheckboxRefus == 'true') {
            $subvention->setMontantOuQteAttribues(0);
            $subvention->setCommentaireAttributeur("Motif du refus : ".$commentaireAttributeurParam);
            $etatSubvention = $etatSubventionRepository->find(3);
            $subvention->setEtat($etatSubvention);
        } else {
            $subvention->setMontantOuQteAttribues($montantAttribueParam);
            $subvention->setCommentaireAttributeur($commentaireAttributeurParam);
            $etatSubvention = $etatSubventionRepository->find(1);
            $subvention->setEtat($etatSubvention);
        }

        $subventionRepository->add($subvention);
        $em->persist($subvention);
        $em->flush($subvention);

        return $this->render('subvention/index.html.twig', [
            'subvention' => $subvention,
            'associations' => $associationRepository->findAll(),
            'etatSubventions' => $etatSubventionRepository->findAll(),
            'subventions' => $subventionRepository->findAll(),
        ]);
    }

//    #[Route('/{id}', name: 'app_subvention_show', methods: ['GET'])]
//    public function show(Subvention $subvention): Response
//    {
//        return $this->render('subvention/show.html.twig', [
//            'subvention' => $subvention,
//        ]);
//    }

    #[Route('/{id}/edit', name: 'app_subvention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Subvention $subvention, SubventionRepository $subventionRepository): Response
    {
        $form = $this->createForm(SubventionType::class, $subvention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subventionRepository->add($subvention);
            return $this->redirectToRoute('app_subvention_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('subvention/edit.html.twig', [
            'subvention' => $subvention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subvention_delete', methods: ['POST'])]
    public function delete(Request $request, Subvention $subvention, SubventionRepository $subventionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subvention->getId(), $request->request->get('_token'))) {
            $subventionRepository->remove($subvention);
        }

        return $this->redirectToRoute('app_subvention_index', [], Response::HTTP_SEE_OTHER);
    }
}
