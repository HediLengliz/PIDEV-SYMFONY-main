<?php

namespace App\Controller;

use App\Form\CommentType;
use App\Entity\Article;
//use App\Form\CommentFormType;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use App\Service\PdfService;



class ClientArticleController extends AbstractController
{
    #[Route('/client/article', name: 'app_client_article')]
    public function index(): Response
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepository->findAll();

        return $this->render('client_article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/client/article/{id}', name: 'app_client_articlebyid')]
    public function article($id, Request $request, FlashyNotifier $flashy, EntityManagerInterface $entityManager): Response
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepository->find($id);

        if (!$articles) {
            throw $this->createNotFoundException('Article not found');
        }

        // Fetch comments associated with the article
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $commentRepository->findBy(['article' => $articles]);

        // Create a new comment form
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the article for the comment
            $comment->setArticle($articles);

            // Persist the comment to the database
            $entityManager->persist($comment);
            $entityManager->flush();

            // Show a success message
            $flashy->success('Commentaire ajouté!');

            // Redirect to a different route after successful submission
            return $this->redirectToRoute('app_comment_index');
        }

        // Render the template with the article, comment form, and comments
        return $this->render('client_article/index.html.twig', [
            'article' => $articles,
            'form' => $form->createView(),
            'comments' => $comments,
            'article_authorname' => $articles->getAuthorName(),
        ]);
    }


    public function showArticle(Request $request, EntityManagerInterface $entityManager, $id): Response
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);


        // Create a new instance of the comment form
        $commentForm = $this->createForm(CommentType::class);

        // Handle form submission if applicable
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Process the form submission
            // For example, save the comment to the database
            $comment = $commentForm->getData();
            $entityManager->persist($comment);
            $entityManager->flush();

            // Optionally, add a success message
            $this->addFlash('success', 'Your comment has been submitted successfully.');
        }

        // Render the template, passing the article and form variables
        return $this->render('comment/_form.html.twig', [
            'article' => $article,
            'form' => $commentForm->createView(),
        ]);
    }
//    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
//    public function new(Request $request, EntityManagerInterface $entityManager, FlashyNotifier $flashy): Response
//    {
//        $comment = new Comment();
//        $form = $this->createForm(CommentType::class, $comment);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($comment);
//            $entityManager->flush();
//            $flashy->success('Commentaire ajouté!');
//
//            return $this->redirectToRoute('app_client_article', [], Response::HTTP_SEE_OTHER);
//        }
//
//        if ($form->isSubmitted() && !$form->isValid()) {
//            $flashy->error('Failed to add comment. Please check the form.');
//        }
//
//        return $this->renderForm('', [
//            'comment' => $comment,
//            'form' => $form,
//        ]);
//    }
    #[Route('/pdf/{id}', name: 'article.pdf')]
    public function generatePdfPersonne(article $article = null, PdfService $pdf) {
        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }

        $html = $this->renderView('article/showPdf.html.twig', ['article' => $article]);
        $pdf->showPdfFile($html);
        return new Response();

    }
}
