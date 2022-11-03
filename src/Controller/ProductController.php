<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('product/index.html.twig', [
            'product' => $productRepository->findAll(),
        ]);
    }

    //partie détails produit

    #[Route('/product/{id}', name: 'details_product')]
    public function details(Product $product): Response
    {

        if(!$product){

            return $this->redirectToRoute('app_home');
        }

     return $this->render('product/single_product.html.twig', [
        'product' => $product,
    ]);

}

    

    #[Route('/product/author/{id}', name: 'author_product')]
    public function show_product_by_author(Product $product): Response
     {
        
      return $this->render('home/index.html.twig', [
           'product'=>$product,
       ]);
     }

     

}
