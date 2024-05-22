<?php

namespace App\Controller;
use App\Controller\PdfController;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);

    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();
            $imageFile = $form['image']->getData();
        if ($imageFile) {
            // Move the uploaded file to a directory or handle it as needed
            // For example, you can move it to a specific directory and store the file path in your entity
            $newFilename = md5(uniqid()).'.'.$imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            // Store the file path in your entity
            $article->setImage($newFilename);
        }

        $entityManager->persist($article);
        $entityManager->flush();
        $flashy->success('Article ajouté!');

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('article/new.html.twig', [
        'article' => $article,
        'form' => $form,
    ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function show(Article $article, Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setArticle($article);
            $entityManager->persist($comment);
            $entityManager->flush();
            $flashy->success('Commentaire ajouté!');

            // Redirect back to the article page after submitting the comment
            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
        }

        // Render the article page with the comment form
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->success('Commentaire Modifier avec success!');

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
    #[Route('/{title}/delete', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getTitle(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/{id}/comment', name: 'app_article_comment', methods: ['POST'])]
    public function comment(Request $request, EntityManagerInterface $entityManager, $id,FlashyNotifier $flashy): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $commentForm = $this->createForm(CommentType::class);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = $commentForm->getData();
            $comment->setArticle($article); // Assuming Comment entity has a property 'article' to associate it with the article
            $entityManager->persist($comment);
            $entityManager->flush();
            $flashy->success('Article ajouté!');
            $this->addFlash('success', 'Your comment has been submitted successfully.');
        }

        // Render the template, passing the article and form variables

        return $this->render('client_article/index.html.twig', [
            'article' => $article,
            'form' => $commentForm->createView(),
        ]);
    }

}
