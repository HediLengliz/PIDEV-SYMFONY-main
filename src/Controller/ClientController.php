<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function client(): Response
    {
        return $this->render('client/index.html.twig');
    }
    #[Route('/clienta', name: 'app_clienta')]
    public function clienta(ArticleRepository $articleRepository,FlashyNotifier $flashy ): Response
    {

        // $flashy->success('explorer notre articles !', 'http://your-awesome-link.com');
        return $this->render('client/clienta.html.twig',[
            'articles' => $articleRepository->findAll(),
        ]);
    }
    #[Route('/HomePage', name: 'Home_Page')]
            public function HomePage(): Response
            {
                return $this->render('client/HomePage.html.twig');
            }
}
