<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository,Request $request): Response
    {

            return $this->render('comment/index.html.twig', [
                'comments' => $commentRepository->findAll(),
            ]);
        }

    public function Paginator(Request $request, PaginatorInterface $paginator, CommentRepository $commentRepository): Response
    {

        $query = $commentRepository->findAllQueryASC();

        $comments = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Current page number
            10 // Number of items per page
        );

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }
    public function Sort(Request $request, CommentRepository $commentRepository): Response
    {
        $sortBy = $request->query->get('sort_by', 'id');
        $sortOrder = $request->query->get('sort_order', 'ASC');

        $comments = $commentRepository->findBy([], [$sortBy => $sortOrder]);

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

        #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
         public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
       {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();
            $flashy->success('Commentaire ajouté!');


            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
      }


    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, EntityManagerInterface $entityManager, FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->success('Commentaire modifier!');


            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager, FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
            $flashy->warning('Commentaire supprimé!');
        }

        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
