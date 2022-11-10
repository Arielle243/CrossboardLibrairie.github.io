<?php

namespace App\Controller;

use App\Entity\Lignecommande;
use App\Form\Lignecommande1Type;
use App\Repository\LignecommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lignecommande')]
class LignecommandeController extends AbstractController
{
    #[Route('/', name: 'app_lignecommande_index', methods: ['GET'])]
    public function index(LignecommandeRepository $lignecommandeRepository): Response
    {
        return $this->render('lignecommande/index.html.twig', [
            'lignecommandes' => $lignecommandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lignecommande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LignecommandeRepository $lignecommandeRepository): Response
    {
        $lignecommande = new Lignecommande();
        $form = $this->createForm(Lignecommande1Type::class, $lignecommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lignecommandeRepository->save($lignecommande, true);

            return $this->redirectToRoute('app_lignecommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lignecommande/new.html.twig', [
            'lignecommande' => $lignecommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lignecommande_show', methods: ['GET'])]
    public function show(Lignecommande $lignecommande): Response
    {
        return $this->render('lignecommande/show.html.twig', [
            'lignecommande' => $lignecommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lignecommande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lignecommande $lignecommande, LignecommandeRepository $lignecommandeRepository): Response
    {
        $form = $this->createForm(Lignecommande1Type::class, $lignecommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lignecommandeRepository->save($lignecommande, true);

            return $this->redirectToRoute('app_lignecommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lignecommande/edit.html.twig', [
            'lignecommande' => $lignecommande,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_lignecommande_delete', methods: ['POST'])]
    public function delete(Request $request, Lignecommande $lignecommande, LignecommandeRepository $lignecommandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lignecommande->getId(), $request->request->get('_token'))) {
            $lignecommandeRepository->remove($lignecommande, true);
        }

        return $this->redirectToRoute('app_lignecommande_index', [], Response::HTTP_SEE_OTHER);
    }
}
