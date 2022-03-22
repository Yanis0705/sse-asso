<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             UtilisateurRepository $utilisateurRepository
    ): Response
    {
        $user = new Utilisateur();
        $tousLesUtilisateurs = $utilisateurRepository->findAll();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $isAdmin = $user->getAdministrateur();
            $email = $user->getEmail();

            foreach ($tousLesUtilisateurs  as $value) {
                if ($value->getEmail() == $email) {
                    $this->addFlash('error', "Ce mail existe déjà");
                }
            }
            if ($isAdmin == false) {
                $user->setRoles(['ROLE_USER']);
            } else {
                $user->setRoles(['ROLE_ADMIN']);
            }

            $user->setPassword(
            $userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
