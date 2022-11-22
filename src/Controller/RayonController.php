<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RayonController extends AbstractController
{
    #[Route('/rayon', name: 'app_rayon')]
    public function index(): Response
    {
        return $this->render('rayon/index.html.twig', [
            'controller_name' => 'RayonController',
        ]);
    }
}
