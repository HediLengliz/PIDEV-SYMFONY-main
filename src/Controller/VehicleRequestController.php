<?php

namespace App\Controller;
use App\Entity\User;

use App\Entity\VehicleRequest;
use App\Form\VehicleRequestType;
use App\Repository\VehicleRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notification;

#[Route('/vehicle/request')]
class VehicleRequestController extends AbstractController
{
    #[Route('/', name: 'app_vehicle_request_index', methods: ['GET'])]
    public function index(VehicleRequestRepository $vehicleRequestRepository): Response
    {
        return $this->render('vehicle_request/index.html.twig', [
            'vehicle_requests' => $vehicleRequestRepository->findAll(),
        ]);
    }

    #[Route('/new_VehicleRequest', name: 'app_vehicle_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicleRequest = new VehicleRequest();
        $form = $this->createForm(VehicleRequestType::class, $vehicleRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicleRequest->setRequestUser($this->getUser());
            $entityManager->persist($vehicleRequest);
            $entityManager->flush();
            $notification = new Notification();
            $typeInsurance = $vehicleRequest->getTypeInsurance();
            $titre = 'Demande d\'assurance ' . $typeInsurance;
            $notification->setTitre($titre);
            $notification->setMessage('Une nouvelle demande d\'assurance a été ajoutée.');
            $notification->setDateNotification(date('Y-m-d H:i:s'));
            $entityManager->persist($notification);
            $entityManager->flush();
            return $this->redirectToRoute('app_vehicle_request_show_paruser', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicle_request/new.html.twig', [
            'vehicle_request' => $vehicleRequest,
            'form' => $form,
        ]);
    }
    #[Route('/user/showv', name: 'app_vehicle_request_show_paruser', methods: ['GET'])]
    public function showParUser(VehicleRequestRepository $req): Response
    {
        $user=$this->getUser();
        if ($user instanceof User){
            // dd($user);
            $requ=$req->findBy(['requestUser'=>$user->getId()]);
            // $requests=$user->getRequests();
        }
        // dd($requ);
        return $this->render('vehicle_request/userRequest.html.twig', [
            'vehicle_requests' => $requ,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicle_request_show', methods: ['GET'])]
    public function show(VehicleRequest $vehicleRequest): Response
    {
        return $this->render('vehicle_request/show.html.twig', [
            'vehicle_request' => $vehicleRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehicle_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VehicleRequest $vehicleRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehicleRequestType::class, $vehicleRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicle_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicle_request/edit.html.twig', [
            'vehicle_request' => $vehicleRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicle_request_delete', methods: ['POST'])]
    public function delete(Request $request, VehicleRequest $vehicleRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicleRequest->getId(), $request->request->get('_token'))) {

            $entityManager->remove($vehicleRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehicle_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
