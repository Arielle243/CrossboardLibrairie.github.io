<?php

namespace App\Controller\Home;

use App\Entity\Comment;
use App\Entity\Commande;
use App\Entity\Product;
use App\Form\CommentType;
use App\Entity\Lignecommande;
use App\Form\LigneCommandeType;
use App\Repository\CommandeRepository;
use App\Repository\ProductRepository;
use App\Repository\LignecommandeRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\ValidatePanierType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


  #[Route('/', name: 'home-')]

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
        public function index(): Response
        {

        return $this->render('home/index.html.twig');
     }



  
  /**
   * !--------------  PARTIE PRODUIT--------------------------*/


        #[Route('/product', name: 'product')]

        public function product(ProductRepository $productRepository, Request $request, 
        EntityManagerInterface $entityManager): Response
        {
            return $this->render('home/list_product.html.twig', [
                'product' => $productRepository->findAll(),
            ]);
        }

        //------------------------------------------DETAILS DU PRODUIT--------------------------------------
        // on intègre la commande ayant un staut panier et y'a que l'utiliateur connecter qui peut avoir un panier

        #[Route('/product/{id}', name: 'details', methods:['GET', 'POST'])]
        public function details(Request $request, Product $product, CommandeRepository 
        $commandeRepository, LignecommandeRepository $lignecommandeRepository, 
        EntityManagerInterface $entityManager): Response
        {
            $lignecommandes = new Lignecommande();                
            $form = $this->createForm(LigneCommandeType::class, $lignecommandes);
            $form->handleRequest($request);
            $panier = $commandeRepository->findOneBy([
                'statutCommande' => 'panier',
                'user' => $this->getUser(),
            ]);
            if($form->isSubmitted() && $form->isValid()) {
                $lignecommandes->setProduct($product);
                $lignecommandes->setCommandes($panier);
                //$lignecommandeRepository->add($lignecommandes, true);
                $entityManager->persist($lignecommandes);
                $entityManager->flush();
                return $this->redirectToRoute('home-panier', [], Response::HTTP_SEE_OTHER);
            }
                        if(!$product){
                    return $this->redirectToRoute('home-index');
                }
                    return $this->renderForm('home/single_product.html.twig', [
                        'product' => $product,
                        'form' => $form,
                        'commande' => $panier,
                        'lignecommande' => $lignecommandes,
                        'button_label' => 'Ajouter au panier',
                ]);
            }
    



        /**
 * !--------------  PARTIE PANIER--------------------------*/

    #[Route('/panier', name: 'panier', methods: ['GET', 'POST'])]
    public function panier(CommandeRepository 
    $commandeRepository, Request $request, 
    EntityManagerInterface $entityManager): Response
    {
         // on va récupérer le panier pour l'afficher, c'est à dire la commande qui a le statut 'panier et qui appartient à l'utilisateur connecté
        $panier = $commandeRepository->findOneBy([
            'statutCommande' => 'panier',
            'user' => $this->getUser(),
        ]);
    // on va mettre en place un bouton qui permettra de valider le panier, càd modifier le statut  du panier pour lui donner le statut 'en cours de préparation'
    $form = $this->createForm(ValidatePanierType::class, 
    $panier);
    $form->handleRequest($request);
     if($form->isSubmitted() && $form->isValid()) {
         $date = new \DatetimeImmutable('now');
         // on change le statut du panier
         $panier->setStatutCommande('en cours de préparation');
        // on met à jour le statut, donc il faut mettre aussi à jour la propriété 'updatedAt'
    $panier->setUpdatedAt($date);
     // on persiste les données
    $entityManager->persist($panier);
    $entityManager->flush();
     // n'oublions pas de créer un nouveau panier : une nouvelle commande qui appartient au client connecté et qui a le statut 'panier'
    $commande = new Commande();
    $commande->setUser($this->getUser());
    $commande->setStatutCommande('panier');
    $commande->setDateCommande($date);
    $commande->setUpdatedAt($date);
     // on persiste les données
    $entityManager->persist($panier);
    $entityManager->flush();
    
    $entityManager->persist($commande);
    $entityManager->flush();
     // on redirige vers l'accueil
     return $this->redirectToRoute('home-index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('home/panier.html.twig', [
     'panier' => $panier,
     'form' => $form,
        ]);
    

    }




}
