<?php

namespace App\Controller;
use App\Entity\Question;

use App\Entity\ServiceProperty;
use App\Form\ServicePropertyType;
use App\Repository\ServicePropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;

#[Route('/service/property')]
class ServicePropertyController extends AbstractController
{
    #[Route('/', name: 'app_service_property_index', methods: ['GET'])]
    public function index(ServicePropertyRepository $servicePropertyRepository): Response
    {
        return $this->render('service_property/index.html.twig', [
            'service_properties' => $servicePropertyRepository->findAll(),
        ]);
    }

    #[Route('/propertyquestion/{id}', name: 'app_service_property_index_per_question', methods: ['GET'])]
    public function index1($id,ServicePropertyRepository $servicePropertyRepository): Response
    {
        return $this->render('service_property/showperquestion.html.twig', [
            'service_properties' => $servicePropertyRepository->findBy(["question"=>$id]),
            'id' => $id,
        ]);
    }

    #[Route('/{id}/new', name: 'app_service_property_new', methods: ['GET', 'POST'])]
    public function newService($id,Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $serviceProperty = new ServiceProperty();
        $form = $this->createForm(ServicePropertyType::class, $serviceProperty);
        $form->handleRequest($request);
        $question = $entityManager->getRepository(Question::class)->find($id);
        $serviceProperty->setQuestion($question);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceProperty);
            $entityManager->flush();
            $flashy->success('ServiceProperty created !');

            return $this->redirectToRoute('app_question_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_property/new.html.twig', [
            'service_property' => $serviceProperty,
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}', name: 'app_service_property_show', methods: ['GET'])]
    public function show($id,ServiceProperty $serviceProperty,FlashyNotifier $flashy): Response
    {

        return $this->render('service_property/show.html.twig', [
            'service_property' => $serviceProperty,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_property_edit', methods: ['GET', 'POST'])]
    public function edit($id,Request $request, ServiceProperty $serviceProperty, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(ServicePropertyType::class, $serviceProperty);
        $form->handleRequest($request);
        $questionId = $serviceProperty->getQuestion()->getId();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->success('ServiceProperty updated !');

            return $this->redirectToRoute('app_question_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_property/edit.html.twig', [
            'service_property' => $serviceProperty,
            'form' => $form,
            'id' => $questionId,
        ]);
    }

    #[Route('/{id}', name: 'app_service_property_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceProperty $serviceProperty, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $questionId = $serviceProperty->getQuestion()->getId();
        if ($this->isCsrfTokenValid('delete'.$serviceProperty->getId(), $request->request->get('_token'))) {
            $entityManager->remove($serviceProperty);
            $entityManager->flush();
            $flashy->success('ServiceProperty deleted !');

        }

        return $this->redirectToRoute('app_question_show', ['id' => $questionId], Response::HTTP_SEE_OTHER);
    }
}
