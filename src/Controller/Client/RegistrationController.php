<?php

namespace App\Controller\Client;

use App\Entity\User;


use App\Entity\Commande;
use App\Form\RegistrationFormType;
use App\Repository\CommandeRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator ,EntityManagerInterface $entityManager, CommandeRepository $commandeRepository, AppCustomAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
               // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
            $user,
            $form->get('plainPassword')->getData()
              )
           );
            //les utilisateurs inscrit avec ce formulaires auront un rôle client
            $user->setRoles(['ROLE_CLIENT']);
            $user->setStatut(True);
        
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $date = new \Datetime('now');
            $dateUpdate = new \DatetimeImmutable('now');
            $commande = new Commande();
            $commande->setUser($user);
            $commande->setStatutCommande('panier');
            $commande->setDateCommande($date);
            $commande->setUpdatedAt($dateUpdate);
            //$commandeRepository->add($commande, true); cette commande ne marche pas sur symfony 6 et on utilise la commande qui vient
            //juste après de persist.
            $entityManager->persist($commande);
            $entityManager->flush();


            
             $userAuthenticator->authenticateUser(
              $user, 
              $authenticator, 
              $request
          );          
 
        
          return $this->redirectToRoute('app_home');
        }

        return $this->render('client/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}