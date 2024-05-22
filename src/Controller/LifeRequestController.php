<?php

namespace App\Controller;

use App\Entity\InsuranceRequest;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\LifeRequest;
use App\Form\LifeRequestType;
use App\Repository\LifeRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Notification;
use App\Repository\InsuranceRequestRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;

#[Route('/life/request')]
class LifeRequestController extends AbstractController
{
    #[Route('/', name: 'app_life_request_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, LifeRequestRepository $lifeRequestRepository, Request $request
): Response
    {
    $pagination = $paginator->paginate(
                           $lifeRequestRepository->findAll(),
                           $request->query->getInt('page', 1), // Get the page number from the request
                           5 // Number of items per page
                       );
            return $this->render('life_request/index.html.twig', [
                'life_requests' => $pagination,
            ]);

    }

    #[Route('/new', name: 'app_life_request_new', methods: ['GET', 'POST'])]
    public function new(FlashyNotifier $flashy, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $lifeRequest = new LifeRequest();
        $form = $this->createForm(LifeRequestType::class, $lifeRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
                // Validate form data using Symfony Validator component
                $violations = $validator->validate($form->getData());

                if (count($violations) > 0) {
                    // Construct an array of error messages
                    $errorMessages = [];
                    foreach ($violations as $violation) {
                        $errorMessages[] = $violation->getMessage();
                    }

                    // Pass error messages to the template
                    return $this->render('life_request/new.html.twig', [
                        'form' => $form->createView(),
                        'error_messages' => $errorMessages,
                    ]);
                }
            }

        if ($form->isSubmitted() && $form->isValid()) {
            $lifeRequest->setRequestUser($this->getUser());
            $entityManager->persist($lifeRequest);
            $entityManager->flush();
            $flashy->success('save !');
            $notification = new Notification();
            $typeInsurance = $lifeRequest->getTypeInsurance();
            $titre = 'Demande d\'assurance ' . $typeInsurance;
            $notification->setTitre($titre);
            $notification->setMessage('Une nouvelle demande d\'assurance a été ajoutée.');
            $notification->setDateNotification(date('Y-m-d H:i:s'));
            $entityManager->persist($notification);
            $entityManager->flush();

            return $this->redirectToRoute('app_life_request_show_paruser', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('life_request/new.html.twig', [
            'life_request' => $lifeRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_life_request_show', methods: ['GET'])]
    public function show(LifeRequest $lifeRequest): Response
    {
        return $this->render('life_request/show.html.twig', [
            'life_request' => $lifeRequest,
        ]);
    }

    #[Route('/user/show', name: 'app_life_request_show_paruser', methods: ['GET'])]
    public function showParUser(LifeRequestRepository $req): Response
    {
        $user=$this->getUser();
        if ($user instanceof User){
            // dd($user);
            $requ=$req->findBy(['requestUser'=>$user->getId()]);
            // $requests=$user->getRequests();
        }
        // dd($requ);
        return $this->render('life_request/userRequest.html.twig', [
            'life_requests' => $requ,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_life_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LifeRequest $lifeRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LifeRequestType::class, $lifeRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_life_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('life_request/edit.html.twig', [
            'life_request' => $lifeRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_life_request_delete', methods: ['POST'])]
    public function delete(Request $request, LifeRequest $lifeRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lifeRequest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lifeRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_life_request_show_paruser', [], Response::HTTP_SEE_OTHER);
    }
}
