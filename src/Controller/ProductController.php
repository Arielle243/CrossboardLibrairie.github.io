<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentFormType;
use App\Service\FileUploader;
use App\Service\CommentService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @method User getUser()
 */


class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product')]
   /*  public function index(ProductRepository $productRepository): Response */
   /*  { */
   /*      return $this->renderForm('product/index.html.twig',[ */
   /*          'products' => $productRepository->findAll(), */
   /*      ]); */
   /*  } */

   public function show(?Product $product, CommentService $commentService): Response
   {
       if (!$product) {
           return $this->redirectToRoute('app_home');
       }

       $parameters = [
           'entity' => $product
       ];

       if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
           $commentForm = $this->createForm(CommentFormType::class,  new Comment($product, $this->getUser()));
           $parameters['commentForm'] = $commentForm;
       }

       return $this->renderForm('product/index.html.twig', $parameters);
   }

   #[Route('/ajax/products/{id}/comments', name: 'product_list_comments', methods: ['GET'])]
   public function listComments(?Product $product, NormalizerInterface $normalizer): Response
   {
       $comments = $normalizer->normalize($product->getComments(), context: [
           'groups' => 'comment'
       ]);

       return $this->json($comments);
   }

}
