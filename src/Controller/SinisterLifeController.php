<?php

namespace App\Controller;

use App\Entity\Sinistre;
use App\Entity\SinisterLife;
use App\Entity\User as EntityUser;
use App\Form\SinisterLifeType;
use App\Repository\SinisterLifeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Util\ClassUtils;
use App\Service\TwilioService;
use App\Entiy\User;
#[Route('/sinisterlife')]
class SinisterLifeController extends AbstractController
{
    #[Route('/', name: 'app_sinister_life_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, SinisterLifeRepository $sinisterLifeRepository, Request $request): Response

    {
        $pagination = $paginator->paginate(
            $sinisterLifeRepository->findAll(),
            $request->query->getInt('page', 1), // Get the page number from the request
            5 // Number of items per page
        );
        return $this->render('sinister_life/index.html.twig', [
            'sinister_lives' => $pagination,
        ]);

    }
    private $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    #[Route('/new', name: 'app_sinister_life_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sinisterLife = new SinisterLife();
        $form = $this->createForm(SinisterLifeType::class, $sinisterLife);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sinisterLife);
            $entityManager->flush();

            $userPhoneNumber = $sinisterLife->getSinisterUser()->getPhoneNumber();
            $countryCode = '+216' ;
            $fullPhoneNumber = $countryCode . $userPhoneNumber ;
            $this->twilioService->sendSms(
                $fullPhoneNumber,
                'Your Sinister Life has been added successfully, We will contact you when it\'s treated!'
            );
            return $this->redirectToRoute('app_sinister_life_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sinister_life/new.html.twig', [
            'sinister_life' => $sinisterLife,
            'form' => $form,
        ]);
    }
    #[Route('/user/show/sl', name: 'app_life_show_paruser', methods: ['GET'])]
    public function showParUser(SinisterLifeRepository $req): Response
    {
        $user=$this->getUser();
        if ($user instanceof EntityUser){

           
            $requ=$req->findBy(['sinisterUser'=>$user->getId()]);
            
        }
       
        return $this->render('sinister_property/userRequest.html.twig', [
            'sinister_properties' => $requ,
        ]);
    }

    #[Route('/{id}', name: 'app_sinister_life_show', methods: ['GET'])]
    public function show(SinisterLife $sinisterLife): Response
    {
        return $this->render('sinister_life/show.html.twig', [
            'sinister_life' => $sinisterLife,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_sinister_life_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SinisterLife $sinisterLife, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SinisterLifeType::class, $sinisterLife);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uow = $entityManager->getUnitOfWork();
            $uow->computeChangeSets();

            $changes = $uow->getEntityChangeSet($sinisterLife);

            if (count($changes) > 0) {
                $entityManager->flush();
                $this->addFlash('success', 'SinisterLife updated successfully.');
            } else {
                $this->addFlash('warning', 'No changes have been made, Please update before submitting.');
            }

            return $this->redirectToRoute('app_sinister_life_index');
        }

        return $this->renderForm('sinister_life/edit.html.twig', [
            'sinister_life' => $sinisterLife,
            'form' => $form,
        ]);
    }


  /*  #[Route('/{id}/edit', name: 'app_sinister_life_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SinisterLife $sinisterLife, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(SinisterLifeType::class, $sinisterLife);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->getUnitOfWork()->computeChangeSets();

            $changes = $entityManager->getUnitOfWork()->getEntityChangeSet($sinisterLife);

            if (count($changes) > 0) {

                $entityManager->flush();
                $this->addFlash('success', 'SinisterLife updated successfully.');
            } else {
                $this->addFlash('warning', 'No changes have been made.');
            }

            return $this->redirectToRoute('app_sinister_life_index');
        }

        return $this->renderForm('sinister_life/edit.html.twig', [
            'sinister_life' => $sinisterLife,
            'form' => $form,
        ]);
    }
*/
    private function isSinisterLifeModified(SinisterLife $original, SinisterLife $updated): bool
    {
        $changesDetected = $original->getDateSinister() !== $updated->getDateSinister()
            || $original->getLocation() !== $updated->getLocation()
            || $original->getAmountSinister() !== $updated->getAmountSinister()
            || $original->getStatusSinister() !== $updated->getStatusSinister()
            || $original->getDescription() !== $updated->getDescription()
            || $original->getBeneficiaryName() !== $updated->getBeneficiaryName();

        if (!$changesDetected) {
            dump('No changes detected.');
        } else {
            dump('Changes detected.');
        }

        return $changesDetected;
    }

    #[Route('/{id}', name: 'app_sinister_life_delete', methods: ['POST'])]
    public function delete(Request $request, SinisterLife $sinisterLife, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sinisterLife->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sinisterLife);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sinister_life_index', [], Response::HTTP_SEE_OTHER);
    }
}
