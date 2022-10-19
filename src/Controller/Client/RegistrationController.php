<?php

namespace App\Controller\Client;

use App\Entity\User;
use App\Service\FileUploader;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
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

        $user->setRoles(['ROLE_CLIENT']);
        $user = $this->getUser();
        
        $entityManager->persist($user);
        $entityManager->flush();
// do anything else you need here, like send an email
//les utilisateurs inscrit avec ce formulaires auront un rôle client

                return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
);


             // on récupère le fichier présent dans le formulaire
             $picture = $form->get('picture')->getData();
             // si le champs picture est renseigné (si $picture existe)
             if($picture){
                 // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/upload/images/
                 $fileName = $fileUploader->upload($picture);
                 // on renseigne la propriété picture de l'article avec ce nom de fichier.
                 $user->setPicture($fileName);
             }
 
        
        }

        return $this->render('client/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
