<?php

namespace App\Controller;

use App\Entity\Remorqueur;
use App\Form\RemorqueurType;
use App\Repository\RemorqueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/remorqueur')]
class RemorqueurController extends AbstractController
{
   
    #[Route('/', name: 'app_remorqueur_index', methods: ['GET'])]
    public function index(RemorqueurRepository $remorqueurRepository): Response
    {
        return $this->render('remorqueur/index.html.twig', [
            'remorqueurs' => $remorqueurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_remorqueur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $remorqueur = new Remorqueur();
        $form = $this->createForm(RemorqueurType::class, $remorqueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($remorqueur);
            $entityManager->flush();

            return $this->redirectToRoute('app_remorqueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remorqueur/new.html.twig', [
            'remorqueur' => $remorqueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_remorqueur_show', methods: ['GET'])]
    public function show(Remorqueur $remorqueur): Response
    {
        return $this->render('remorqueur/show.html.twig', [
            'remorqueur' => $remorqueur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_remorqueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Remorqueur $remorqueur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RemorqueurType::class, $remorqueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_remorqueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remorqueur/edit.html.twig', [
            'remorqueur' => $remorqueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_remorqueur_delete', methods: ['POST'])]
    public function delete(Request $request, Remorqueur $remorqueur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$remorqueur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($remorqueur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_remorqueur_index', [], Response::HTTP_SEE_OTHER);
    }
}
