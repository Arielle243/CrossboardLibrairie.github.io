<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Commande;
use App\Form\ValidatePanierType;
use App\Repository\ProductRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


 #[Route('/panier', name: 'panier-')]


class PanierController extends AbstractController
{
    #[Route('/', name: 'index' , methods: ['GET', 'POST'])]

    public function index(CommandeRepository $commandeRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // on va récupérer le panier pour l'afficher, c'est à dire la commande qui a le statut 'panier et qui appartient à l'utilisateur connecté
        $panier = $commandeRepository->findOneBy([
            'statutCommande' => 'panier',
            'user' => $this->getUser(),
        ]);

        // on va mettre en place un bouton qui permettra de valider le panier, càd modifier le statut du panier pour lui donner le statut 'en cours de préparation'
        $form = $this->createForm(ValidatePanierType::class, $panier);
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
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);

        }
        return $this->renderForm('home/panier.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }




}
