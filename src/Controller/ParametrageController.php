<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParametrageController extends AbstractController
{
    #[Route('/parametrage', name: 'parametrage')]
    public function index(): Response

    {
        return $this->render('parametrage/index.html.twig', []);
    }
}