<?php

namespace App\Controller;
use App\Entity\User;

use App\Entity\PropretyRequest;
use App\Form\PropretyRequestType;
use App\Repository\PropretyRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notification;
use App\Entity\InsuranceRequest;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;


#[Route('/proprety/request')]
class PropretyRequestController extends AbstractController
{
    #[Route('/', name: 'app_proprety_request_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, PropretyRequestRepository $propretyRequestRepository, Request $request): Response
    {
     $pagination = $paginator->paginate(
                               $propretyRequestRepository->findAll(),
                               $request->query->getInt('page', 1), // Get the page number from the request
                               5 // Number of items per page
                           );
                return $this->render('proprety_request/index.html.twig', [
                    'proprety_requests' => $pagination,
                ]);

    }

    #[Route('/New_PropretyRequest', name: 'app_proprety_request_new', methods: ['GET', 'POST'])]
    public function new(FlashyNotifier $flashy, Request $request, EntityManagerInterface $entityManager): Response
    {
        $propretyRequest = new PropretyRequest();
        $form = $this->createForm(PropretyRequestType::class, $propretyRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propretyRequest->setRequestUser($this->getUser());
            $entityManager->persist($propretyRequest);
            $entityManager->flush();
            $flashy->success('save !');

$notification = new Notification();
$typeInsurance = $propretyRequest->getTypeInsurance();
$titre = 'Demande d\'assurance ' . $typeInsurance;

$notification->setTitre($titre);

$notification->setMessage('Une nouvelle demande d\'assurance a été ajoutée.');
$notification->setDateNotification(date('Y-m-d H:i:s')); // Ajoutez la date de notification, par exemple la date actuelle

// Persistez l'entité
$entityManager->persist($notification);

// Flush pour sauvegarder dans la base de données
$entityManager->flush();

            return $this->redirectToRoute('app_proprety_request_show_paruser', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proprety_request/new.html.twig', [
            'proprety_request' => $propretyRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proprety_request_show', methods: ['GET'])]
    public function show(PropretyRequest $propretyRequest): Response
    {
        return $this->render('proprety_request/show.html.twig', [
            'proprety_request' => $propretyRequest,
        ]);
    }
    #[Route('/user/showp', name: 'app_proprety_request_show_paruser', methods: ['GET'])]
    public function showParUser(PropretyRequestRepository $req): Response
    {
        $user=$this->getUser();
        if ($user instanceof User){
            // dd($user);
            $requ=$req->findBy(['requestUser'=>$user->getId()]);
            // $requests=$user->getRequests();
        }
        // dd($requ);
        return $this->render('proprety_request/userRequest.html.twig', [
            'proprety_requests' => $requ,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_proprety_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PropretyRequest $propretyRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PropretyRequestType::class, $propretyRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_proprety_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proprety_request/edit.html.twig', [
            'proprety_request' => $propretyRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proprety_request_delete', methods: ['POST'])]
    public function delete(Request $request, PropretyRequest $propretyRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$propretyRequest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($propretyRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_proprety_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
