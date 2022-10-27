<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Service\CommentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class CommentController extends AbstractController
{

    #[Route('/comment', name: 'app_comment')]

    public function index(): Response
    {
    return $this->render('comment/index.html.twig', [
        'controller_name' => 'CommentController',
    ]);

    }

}
