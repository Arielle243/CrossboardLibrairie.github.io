<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\User;
use App\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function show(?Product $product): Response
    {
        if (!$product) {
            return $this->redirectToRoute('app_home');
        }

        $parameters = [
            'entity' => $product

        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $commentForm = $this->createForm(CommentFormType::class,  new Comment($product, $this->getUsers()));
            $parameters['commentForm'] = $commentForm;
        }
        return $this->renderForm('product/index.html.twig', $parameters);
    }
}
