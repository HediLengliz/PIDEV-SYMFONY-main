<?php

namespace App\Controller;
use App\Entity\Question;
use App\Entity\ServiceAuto;
use App\Form\ServiceAutoType;
use App\Repository\ServiceAutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MercurySeries\FlashyBundle\FlashyNotifier;

#[Route('/service/auto')]
class ServiceAutoController extends AbstractController
{
    #[Route('/', name: 'app_service_auto_index', methods: ['GET'])]
    public function index(ServiceAutoRepository $serviceAutoRepository): Response
    {
        return $this->render('service_auto/showperquestion.html.twig', [
            'service_autos' => $serviceAutoRepository->findAll(),
        ]);
    }
    #[Route('/autoquestion/{id}', name: 'app_service_auto_index_per_question', methods: ['GET'])]
    public function index1($id,ServiceAutoRepository $serviceAutoRepository): Response
    {
        return $this->render('service_auto/showperquestion.html.twig', [
            'service_autos' => $serviceAutoRepository->findBy(["question"=>$id]),
        ]);
    }


    #[Route('/{id}/new', name: 'app_service_auto_new', methods: ['GET', 'POST'])]
    public function newService($id,Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $serviceAuto = new ServiceAuto();
        $form = $this->createForm(ServiceAutoType::class, $serviceAuto);
        $form->handleRequest($request);
        $question = $entityManager->getRepository(Question::class)->find($id);
        $serviceAuto->setQuestion($question);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceAuto);
            $entityManager->flush();
            $flashy->success('ServiceAuto created !');


            return $this->redirectToRoute('app_question_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_auto/new.html.twig', [
            'service_auto' => $serviceAuto,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'app_service_auto_show', methods: ['GET'])]
    public function show($id,ServiceAuto $serviceAuto): Response
    {
        return $this->render('service_auto/show.html.twig', [
            'service_auto' => $serviceAuto,
            'id' => $id

        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_auto_edit', methods: ['GET', 'POST'])]
    public function edit($id,Request $request, ServiceAuto $serviceAuto, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(ServiceAutoType::class, $serviceAuto);
        $form->handleRequest($request);
        $questionId = $serviceAuto->getQuestion()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->success('ServiceAuto updated !');

            return $this->redirectToRoute('app_question_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_auto/edit.html.twig', [
            'service_auto' => $serviceAuto,
            'form' => $form,
            'id' => $questionId,
        ]);
    }

    #[Route('/{id}', name: 'app_service_auto_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceAuto $serviceAuto, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $questionId = $serviceAuto->getQuestion()->getId();

        if ($this->isCsrfTokenValid('delete'.$serviceAuto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($serviceAuto);
            $entityManager->flush();
            $flashy->success('ServiceAuto deleted !');

        }

        return $this->redirectToRoute('app_question_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
    }
}
