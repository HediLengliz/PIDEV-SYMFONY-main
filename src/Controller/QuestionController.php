<?php

namespace App\Controller;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;
#[Route('/question')]
class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $filters = $request->get("types");
        if($request->get('ajax')){
            return "ok";
        }
        $pagination = $paginator->paginate(
            $questionRepository->findAll(),
            $request->query->getInt('page', 1), // Get the page number from the request
            5 // Number of items per page
        );
        
        return $this->render('question/index.html.twig', [
            'questions' => $pagination,
            'types' => [1 =>'auto',2 =>'property', 3=>'life'],
        ]);
    }

    #[Route('/new', name: 'app_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy,MailerInterface $mailer): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();
            // $email = (new Email())
        //     ->from('oussemaa782@gmail.com')
        //     ->to('azizbamar16@gmail.com')
        //     ->subject("siuuuuuuuuuuu")
        //     ->text("waaaaaaaaaaa")
        //     ->html('<p>See Twig integration for better HTML integration!</p>');

        // $mailer->send($email);
            $flashy->success('Question created !');


            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
            'services' => $question->getServices(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->success('Question updated !');

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
            $flashy->success('Question deleted !');

        }

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }


}
