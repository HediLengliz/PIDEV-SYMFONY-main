<?php

namespace App\Controller;

use App\Entity\Sinister;
use App\Entity\SinisterVehicle;
use App\Entity\User;
use App\Form\SinisterVehicleType;
use App\Repository\SinisterVehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/constat')]
class ConstatController extends AbstractController
{
    #[Route('/', name: 'app_constat_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator , SinisterVehicleRepository $sinisterVehicleRepository, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $sinisterVehicleRepository->findAll(),
            $request->query->getInt('page', 1), // Get the page number from the request
            4 // Number of items per page
        );
        return $this->render('constat/index.html.twig', [
            'sinister_vehicles' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_constat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sinisterVehicle = new SinisterVehicle();
        $form = $this->createForm(SinisterVehicleType::class, $sinisterVehicle);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $sinisterVehicle->setSinisterUser($this->getUser());
            $entityManager->persist($sinisterVehicle);
            $entityManager->flush();
    
            $message = "Votre déclaration de sinistre véhicule a été enregistrée. Un expert la traitera et vous contactera pour plus d'informations.";
            $this-> addFlash('success',$message);
            return $this->redirectToRoute('app_vehic_show_paruser', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('constat/new.html.twig', [
            'sinister_vehicle' => $sinisterVehicle,
            'form' => $form,
        ]);
    }
    
    #[Route('/user/show/sv', name: 'app_vehic_show_paruser', methods: ['GET'])]
    public function showParUser(SinisterVehicleRepository $req): Response
    {
        $user=$this->getUser();
        if ($user instanceof User){
            // dd($user);
            $requ=$req->findBy(['sinisterUser'=>$user->getId()]);
            
        }
       
        return $this->render('constat/userRequest.html.twig', [
            'sinister_vehicle' => $requ,
        ]);
    }

    #[Route('/show/{id}', name: 'app_constat_show', methods: ['GET'])]
    public function show(SinisterVehicle $sinisterVehicle): Response
    {
        return $this->render('constat/show.html.twig', [
            'sinister_vehicle' => $sinisterVehicle,
        ]);
    }
    #[Route('/{id}', name: 'app_constat_showAdmin', methods: ['GET'])]
    public function showAdmin(SinisterVehicle $sinisterVehicle): Response
    {
        return $this->render('constat/show_admin.html.twig', [
            'sinister_vehicle' => $sinisterVehicle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_constat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SinisterVehicle $sinisterVehicle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SinisterVehicleType::class, $sinisterVehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $message = "Votre déclaration de sinistre véhicule a été modifié.";
            $this-> addFlash('success',$message);
    
            return $this->redirectToRoute('app_vehic_show_paruser');
        }

        return $this->renderForm('constat/edit.html.twig', [
            'sinister_vehicle' => $sinisterVehicle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_constat_delete', methods: ['POST'])]
    public function delete(Request $request, SinisterVehicle $sinisterVehicle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sinisterVehicle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sinisterVehicle);
            $entityManager->flush();
            $message = "Votre déclaration de sinistre véhicule a été supprimé.";
            $this-> addFlash('success',$message);
    
            return $this->redirectToRoute('app_vehic_show_paruser');
        }

       
    }
}
