<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'product' => $productRepository->findAll(),
        ]);
    }


    #[Route('/product/single/{id}', name: 'single_product', methods:['GET'])]
    public function show_product(Product $product): Response
    {
        return $this->render('product/single_product.html.twig', [
            'product' => $product,
            'title'=>'Produit'
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
