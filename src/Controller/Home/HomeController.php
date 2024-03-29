<?php

namespace App\Controller\Home;

use App\Entity\Panier;
use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Form\CommentType;
use App\Entity\LignePanier;
use App\Entity\Lignecommande;
use App\Service\FileUploader;
use App\Form\LigneCommandeType;
use App\Form\CheckoutPanierType;
use App\Form\ValidatePanierType;
use App\Repository\RayonRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommandeRepository;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LignecommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


  #[Route('/', name: 'home-')]

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
        public function index(ProductRepository $productRepository, Request $request, EntityManagerInterface $entityManager): Response
        {

        // Pour afficher les produits par best-seller et par nouveauté
      

        return $this->render('home/index.html.twig', [
             'product' => $productRepository->findBy(['nouveaute'=>true ]),
        ]);
        
            
        }
     



  
  /**
   * !---------------------------------------------PARTIE  PRODUIT--------------------------------------------------------*/


        #[Route('/product', name: 'product')]

        public function product(ProductRepository $productRepository, Request $request, 
        EntityManagerInterface $entityManager): Response
        {
            return $this->render('home/list_product.html.twig', [
                'product' => $productRepository->findAll(),
            ]);
        }



        //------------------------------------------DETAILS DU PRODUIT--------------------------------------
        // on intègre la commande ayant un staut panier et y'a que l'utilisateur connecté qui peut avoir un panier

        #[Route('/product/{title}/details', name: 'details', methods:['GET', 'POST'])]

        public function details(Request $request, Product $product, CommandeRepository 
        $commandeRepository, LignecommandeRepository $lignecommandeRepository, 
        EntityManagerInterface $entityManager): Response
        {
            $lignecommande = new Lignecommande(); 

            //----------------------------formulaire pour ajouter  le produit avec une quantité de produit dans le panier------------------------------------- 

            $form = $this->createForm(LigneCommandeType::class, $lignecommande);
            $form->handleRequest($request);
            $panier = $commandeRepository->findOneBy([
                'statutCommande' => 'panier',
                'user' => $this->getUser(),
            ]);

            if($form->isSubmitted() && $form->isValid()) {

                // boucle pour vérifier si le produit qu'on ajoute et déjà dans le panier, 
                // on récupère la liste des produits présents dans le panier, s'il est on incremente
                $lignecommandeList = $panier->getLignecommandes();
                foreach($lignecommandeList as $item){
                    if($item->getProduct() == $product){
                        $quantite = $item->getQuantite() + 1;
                        $item->setQuantite($quantite);
                        $lignecommandeRepository->save($item, true);
                        return $this->redirectToRoute('home-product', [], Response::HTTP_SEE_OTHER);
                    }
                }
                //sinon on l'ajoute dans le panier comme une nouvelle ligne de commande

                $lignecommande->setProduct($product);
                $lignecommande->setCommandes($panier);

                //$lignecommandeRepository->add($lignecommandes, true);
                $entityManager->persist($lignecommande);
                $entityManager->flush();
                return $this->redirectToRoute('home-panier_checkout', [], Response::HTTP_SEE_OTHER);
            }
                        echo 'Le produit est bien ajouté dans le panier';
           

                    return $this->renderForm('home/single_product.html.twig', [
                        'product' => $product,
                        'form' => $form,
                        'commande' => $panier,
                        'lignecommande' => $lignecommande,
                        'button_label' => 'Ajouter au panier',
                    ]);

                 
                    //-----------------------------------------------------
                    // si on ne trouve pas de produit on rédirige vers l'accueil
                    if(!$product){
                         throw $this->createNotFoundException(
                            'No product found for id '.$id
                        );
                        return $this->redirectToRoute('home-index');
                    }

                    

        }
    



        /**
 * !--------------------------------------------------PARTIE PANIER---------------------------------------------------*/

    #[Route('/panier/validation', name: 'panier_validation', methods: ['GET', 'POST'])]
    public function panier_validation(CommandeRepository $commandeRepository, Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository,  LignecommandeRepository $lignecommandeRepository ) : Response
    {
         // on va récupérer le panier pour l'afficher, c'est à dire la commande qui a le statut 'panier et qui appartient à l'utilisateur connecté
         $panier = $commandeRepository->findOneBy([ 
             'statutCommande' => 'panier', 
             'user' => $this->getUser(),
            
         ]); 




        //-------------------------------------VALIDATION PANIER------------------------------------------------------------------------

        // on va mettre en place un bouton qui permettra de valider le panier, càd modifier le statut  du panier pour lui donner le statut 'en cours de préparation'
        $form = $this->createForm(ValidatePanierType::class, $panier);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                 // on veut récuperer les produits commandés
                $panier->setCreatedAt(new \DatetimeImmutable('now'));
                 // on change le statut du panier
                $panier->setStatutCommande('en cours de préparation');
                // on met à jour le statut, donc il faut mettre aussi à jour la propriété 'updatedAt'
                $panier->setUpdatedAt(new \DatetimeImmutable('now'));
                // on persiste les données
                $entityManager->persist($panier);
                $entityManager->flush();

                 // n'oublions pas de créer un nouveau panier : une nouvelle commande qui appartient au client connecté et qui a le statut 'panier'
                $commande = new Commande();
                $commande->setUser($this->getUser());
                $commande->setStatutCommande('panier');
                $commande->setCreatedAt(new \DatetimeImmutable('now'));
                $commande->setUpdatedAt(new \DatetimeImmutable('now'));

                 // on persiste les données
                $entityManager->persist($commande);
                $entityManager->flush();

                 // on redirige vers l'accueil
                return $this->redirectToRoute('home-index', [], Response::HTTP_SEE_OTHER);
                 $this->addFlash('success', 'Votre commande est bien validée');
                
            }
                 echo 'Votre commande est bien validée';
                 
                return $this->renderForm('home/validation_panier.html.twig', [
                 'panier' => $panier,
                 'form' => $form,
                 'button_label' => 'Payer ma commande',
                    ]); 


    

    }



       

    //----------------------------DELETE LIGNE COMMANDE------------------------------------------------

    #[Route('/delete/{id}', name: 'lignecommande_delete', methods: ['POST'])]
    public function delete_ligneCommande(Request $request, Lignecommande $lignecommande, LignecommandeRepository $lignecommandeRepository, EntityManagerInterface 
        $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lignecommande->getId(), $request->request->get('_token'))) {
            $lignecommandeRepository->remove($lignecommande, true);
        }
        return $this->redirectToRoute('home-panier_checkout', [], Response::HTTP_SEE_OTHER);
    }




    //----------------------------ADD UNE QUANTITE  DANS UNE LIGNE COMMANDE------------------------------------------------------

    #[Route('/addQuantity/{id}', name: 'lignecommande_add', methods: ['GET', 'POST'])]
    public function add_ligneCommande(Request $request, Lignecommande $lignecommande, LignecommandeRepository $lignecommandeRepository): Response
    {
        // On défini la quantite qui sera associé à la ligne de commande en ajoutant 1 pour incrementer 
        $quantite = $lignecommande->getQuantite() + 1 ;
        $lignecommande->setQuantite($quantite);
        //Ensuite on sauvegarde dans la base de données avec la fonction save
        $lignecommandeRepository->save($lignecommande, true);
        // et on rédirige
         return $this->redirectToRoute('home-panier_checkout', [], Response::HTTP_SEE_OTHER);


    }

/*-------------------------------------------------------------------------------------------*/



     //----------------------------RETIRER UNE QUANTITE  DANS UNE LIGNE COMMANDE------------------------------------------------------
     #[Route('/removeQuantity/{id}', name: 'lignecommande_remove', methods: ['GET', 'POST'])]
     public function remove_ligneCommande(Request $request, Lignecommande $lignecommande, LignecommandeRepository $lignecommandeRepository): Response
     {
        $quantite = $lignecommande->getQuantite() - 1 ;
        $lignecommande->setQuantite($quantite);
        $lignecommandeRepository->save($lignecommande, true);

        if ($quantite < 1) {
             $lignecommandeRepository->remove($lignecommande, true);
        }
        return $this->redirectToRoute('home-panier_checkout', [], Response::HTTP_SEE_OTHER);
     }

/*---------------------------------------------------------------------------------------------------*/
            /**------------------PANIER AVANT VALIDATION-------------- */

         #[Route('/panier/checkout', name: 'panier_checkout', methods: ['GET', 'POST'])]
        public function checkout( CommandeRepository $commandeRepository, EntityManagerInterface   $entityManager, ProductRepository $productRepository, Request $request ) : Response {

            // on va récupérer le panier pour l'afficher, c'est à dire la commande qui a le statut 'panier et qui appartient à l'utilisateur connecté
            $panier = $commandeRepository->findOneBy([ 
                'statutCommande' => 'panier', 
                'user' => $this->getUser(),
     
                ]); 

                $formCheckout = $this->createForm(CheckoutPanierType::class, $panier);
                $formCheckout->handleRequest($request);
                if($formCheckout->isSubmitted() && $formCheckout->isValid()) {
                $date = new \DatetimeImmutable('now');
                $panier->setUpdatedAt($date);


                return $this->redirectToRoute('home-panier_validation', [],
                Response::HTTP_SEE_OTHER);

                }
 

                    return $this->renderForm('home/checkout_panier.html.twig', [
                    'panier' => $panier,
                    'formCheckout' => $formCheckout,
                    'button_label' => 'Valider mon panier',

                    ]); 

            }




        /**
 * !--------------------------------------------------PARTIE header-----------------------------*/


        #[Route('/rayon', name: 'rayon')]

        public function rayon(  RayonRepository $rayonRepository, Request $request,
        EntityManagerInterface $entityManager, ProductRepository $product): Response
        {
            return $this->render('rayon/index.html.twig', [
                'rayon' => $rayonRepository->findAll(),
                
            ]);
        }








        /**
 * !--------------------------------------------------PARTIE footer-----------------------------*/

        #[Route('/legacy', name: 'legacy')]
        public function legacy( Request $request,  EntityManagerInterface $entityManager): Response

        {
            return $this->render('home/mentionsLegales.html.twig');
        }






        /**
 * !--------------------------------------------------PARTIE search-----------------------------*/
// mise en place de champs de recherche 

         #[Route('/product_resultat/{critere}', name: 'resultat_recherche')]
            public function productSearch(ProductRepository $productRepository, $critere): Response
            {
                if($critere){
                    $productListSearch = $productRepository->search($critere);
                    if($productListSearch !=[]){
                        // on affiche les résultats
                        return $this->render('home/result.html.twig', [
                            'product'=>$productListSearch,
                            'message'=>'Résultat de la recherche: '.$critere,
                        ]);
                    }else{
                        //on affiche un message 'pas de résultats'
                        return $this->render('home/result.html.twig', [
                            'message'=>'Pas de résultat pour votre recherche '.$critere
                        ]);
                    }
                }else{
                     return $this->render('home/home-index.html.twig', [
                        'product' =>$productRepository->findAll(),
                     ]);
                }
               
            }


 
}



