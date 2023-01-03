<?php

namespace App\Controller\Client;

use App\Entity\User;
use DatetimeImmutable;
use App\Form\UserFormType;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/client')]
class CompteClientController extends AbstractController
{
    #[Route('/', name: 'client_index', methods: ['GET'])]
    public function index_client(UserRepository $userRepository): Response
    {
        return $this->render('client/compteClient/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new_client(Request $request, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        


                $picture = $form->get('picture')->getData();
                // si le champs picture est renseigné (si $picture existe)
                if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé        dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $user->setPicture($fileName);
                }

                $user->setCreatedAt(new DatetimeImmutable('now'));
                $user->setUpdatedAt(new \DatetimeImmutable('now'));

                $userRepository->add($user, true);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'client_show', methods: ['GET'])]
    public function show_client(User $user): Response
    {
        return $this->render('client/compteClient/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'client_edit', methods: ['GET', 'POST'])]
    public function edit_client(Request $request, User $user, UserRepository $userRepository,  FileUploader $fileUploader): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);


                $picture = $form->get('picture')->getData();
                // si le champs picture est renseigné (si $picture existe)
                if($picture){
                // on récupère le nom du fichier téléversé en même temps q
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce 
                $user->setPicture($fileName);
                }


            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/compteClient/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'client_delete', methods: ['POST'])]
    public function delete_client(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
    }
}
