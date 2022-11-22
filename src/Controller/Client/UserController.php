<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {

      
      
         $date = new \Datetime('now');

        return $this->render('client/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}