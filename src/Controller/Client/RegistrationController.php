<?php

namespace App\Controller\Client;

use App\Entity\User;


use App\Entity\Commande;
use App\Service\FileUploader;
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

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator ,EntityManagerInterface $entityManager, CommandeRepository $commandeRepository, AppCustomAuthenticator $authenticator, FileUploader $fileUploader): Response
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
            


             // on récupère le fichier présent dans le formulaire
            $picture = $form->get('picture')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
            $fileName = $fileUploader->upload($picture);
            // on renseigne la propriété picture de l'article avec ce nom de fichier.
            $user->setPicture($fileName);
            }
            
        
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
 
        
          return $this->redirectToRoute('home-index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}