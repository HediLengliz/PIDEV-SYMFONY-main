<?php

namespace App\Controller;
use App\Entity\Question;

use App\Entity\ServiceLife;
use App\Form\ServiceLifeType;
use App\Repository\ServiceLifeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;

#[Route('/service/life')]
class ServiceLifeController extends AbstractController
{
    #[Route('/', name: 'app_service_life_index', methods: ['GET'])]
    public function index(ServiceLifeRepository $serviceLifeRepository): Response
    {
        return $this->render('service_life/index.html.twig', [
            'service_lives' => $serviceLifeRepository->findAll(),
        ]);
    }

    #[Route('/lifequestion/{id}', name: 'app_service_life_index_per_question', methods: ['GET'])]
    public function index1($id,ServiceLifeRepository $serviceLifeRepository): Response
    {
        return $this->render('service_auto/showperquestion.html.twig', [
            'service_lives' => $serviceLifeRepository->findBy(["question"=>$id]),
            'id' => $id,
        ]);
    }


    #[Route('/{id}/new', name: 'app_service_life_new', methods: ['GET', 'POST'])]
    public function newService($id,Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $serviceLife = new ServiceLife();
        $form = $this->createForm(ServiceLifeType::class, $serviceLife);
        $form->handleRequest($request);
        $question = $entityManager->getRepository(Question::class)->find($id);
        $serviceLife->setQuestion($question);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceLife);
            $entityManager->flush();
            $flashy->success('ServiceLife created !');

            return $this->redirectToRoute('app_question_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_life/new.html.twig', [
            'service_life' => $serviceLife,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'app_service_life_show', methods: ['GET'])]
    public function show($id,ServiceLife $serviceLife): Response
    {
        return $this->render('service_life/show.html.twig', [
            'service_life' => $serviceLife,
            'id' => $id

        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_life_edit', methods: ['GET', 'POST'])]
    public function edit($id,Request $request, ServiceLife $serviceLife, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(ServiceLifeType::class, $serviceLife);
        $form->handleRequest($request);
        $questionId = $serviceLife->getQuestion()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->success('ServiceLife updated !');

            return $this->redirectToRoute('app_question_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_life/edit.html.twig', [
            'service_life' => $serviceLife,
            'form' => $form,
            'id' => $questionId,
        ]);
    }

    #[Route('/{id}', name: 'app_service_life_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceLife $serviceLife, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $questionId = $serviceLife->getQuestion()->getId();

        if ($this->isCsrfTokenValid('delete'.$serviceLife->getId(), $request->request->get('_token'))) {
            $entityManager->remove($serviceLife);
            $entityManager->flush();
            $flashy->success('ServiceLife deleted !');

        }

        return $this->redirectToRoute('app_question_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
    }
}
