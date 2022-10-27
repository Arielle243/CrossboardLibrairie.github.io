<?php

namespace App\Controller\Home;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    /* public function index(): Response */
    /* { */
    /*     return $this->render('home/index.html.twig', [ */
    /*         'controller_name' => 'HomeController', */
    /*     ]); */
    /* } */

        public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository ): Response
        {

        $category= $categoryRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'Product' => $productRepository->findAll(),
            'Category'=>$category,

            ]);
        }
}
