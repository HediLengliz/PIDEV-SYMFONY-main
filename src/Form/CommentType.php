<?php

namespace App\Form;

use App\Entity\Comment;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('description', TextareaType::class, [
            'label' => 'description',
            'attr' => ['placeholder' => 'Description'],
        ])
        ->add('rate',ChoiceType::class, [
            'choices' => [
                '★' => 1,
                '★★' => 2,
                '★★★' => 3,
                '★★★★' => 4,
                '★★★★★' => 5,
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'rate',
            'choice_attr' => function($choice, $key, $value) {
                return ['class' => 'star', 'data-value' => $value]; // Add class and data-value attributes to each choice
            },
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
//i want to add the comment form in the article page
// Path: templates/article/show.html.twig
// Compare this snippet from templates/article/show.html.twig:
// {% extends 'base.html.twig' %}
//
// {% block title %}{{ article.title }}{% endblock %}
//
// {% block body %}
//     <h1>{{ article.title }}</h1>
//     <p>{{ article.publishedAt|date('d/m/Y') }}</p>

//     <div class="article">
//         {{ article.content|raw }}
//     </div>
//     <h2>Comments</h2>
//     <div class="comments">
//         {% for comment in article.comments %}
//             <div class="comment">
//                 <div class="metadata">
//                     {{ comment.author }} - {{ comment.createdAt|date('d/m/Y H:i') }}
//                 </div>
//                 <div class="content">
//                     {{ comment.content }}
//                 </div>
//             </div>
//         {% endfor %}
//     </div>
// {% endblock %}

// Add the following code to the end of the file:
//
// <h2>Add a comment</h2>
// {{ form_start(commentForm) }}
//     {{ form_row(commentForm.description) }}
//     {{ form_row(commentForm.rate) }}
//     <button type="submit" class="btn">Submit</button>
// {{ form_end(commentForm) }}
// This code adds a new heading and a form to the article page. The form is created using the comment form type that you created earlier. The form is rendered using the form_start(), form_row(), and form_end() functions. These functions are provided by the Symfony form component and are used to render the form. The form_start() function renders the opening <form> tag, the form_row() function renders the form fields, and the form_end() function renders the closing </form> tag. The comment form is passed to the template from the controller. You'll add this in the next step.
//
// Next, you'll need to update the ArticleController to handle the comment form submission and display the form on the article page.
// Path: src/Controller/ArticleController.php
// Compare this snippet from src/Controller/ArticleController.php:
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
//
// #[Route('/article')]
// class ArticleController extends AbstractController
// {
//     #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
//     public function show(Article $article): Response
//     {
//         return $this->render('article/show.html.twig', [
//             'article' => $article,
//         ]);
//     }
// }
// Add the following code to the end of the file:
//
// #[Route('/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
// public function show(Article $article, Request $request, EntityManagerInterface $entityManager): Response
// {
//     $comment = new Comment();
//     $commentForm = $this->createForm(CommentType::class, $comment);
//     $commentForm->handleRequest($request);
//
//     if ($commentForm->isSubmitted() && $commentForm->isValid()) {
//         $comment->setArticle($article);
//         $entityManager->persist($comment);
//         $entityManager->flush();
//
//         return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
//     }
//
//     return $this->render('article/show.html.twig', [
//         'article' => $article,
//         'commentForm' => $commentForm->createView(),
//     ]);
// }
// This code adds a new route to the show() method of the ArticleController. The route accepts both GET and POST requests. The method creates a new comment form and handles the form submission. If the form is submitted and valid, the comment is associated with the article and persisted to the database. The method then redirects back to the article page. If the form is not submitted or is not valid, the method renders the article page with the comment form.
//
// The comment form is passed to the template from the controller. The form is rendered in the article page using the form_start(), form_row(), and form_end() functions. These functions are provided by the Symfony form component and are used to render the form. The form_start() function renders the opening <form> tag, the form_row() function renders the form fields, and the form_end() function renders the closing </form> tag.
//
// You can now test the comment form on the article page.
//
// To test the comment form, start the web server and navigate to the article page. You should see the article content and a comment form at the bottom of the page. You can submit a comment and verify that it is added to the article page.
//
// Next, you'll add a new feature to the article page that displays the average rating of the article based on the comments.

