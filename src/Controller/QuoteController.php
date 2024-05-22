<?php

namespace App\Controller;
use App\Repository\QuestionRepository;
use App\Repository\ServiceRepository;
use App\Entity\Quote;
use App\Entity\User;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/quote')]
class QuoteController extends AbstractController
{
    #[Route('/', name: 'app_quote_index', methods: ['GET'])]
    public function index(QuoteRepository $quoteRepository): Response
    {
        return $this->render('quote/index.html.twig', [
            'quotes' => $quoteRepository->findAll(),
        ]);
    }

    #[Route('/myquotes', name: 'app_user_quote_index', methods: ['GET'])]
    public function indexUser(QuoteRepository $quoteRepository,UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if($user instanceof User){
            $id = $user->getId();
        }

        return $this->render('quote/index.html.twig', [
            'quotes' => $userRepository->find($id)->getQuotes(),
        ]);
    }

    #[Route('/new', name: 'app_quote_new', methods: ['GET', 'POST'])]
    public function newQuote(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quote);
            $entityManager->flush();

            return $this->redirectToRoute('app_quote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quote/new.html.twig', [
            'quote' => $quote,
            'form' => $form,
        ]);
    }
    #[Route('/new/{type}', name: 'app_quote_new_type', methods: ['GET', 'POST'])]
    public function newQuoteType($type,Request $request, EntityManagerInterface $entityManager,QuestionRepository $questionRepository,ServiceRepository $serviceRepository,UserRepository $userRepository,FlashyNotifier $flashy): Response
    {
        $questions = $questionRepository->findByType($type);
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedServices = json_decode($request->request->get('selectedServices'), true);
            $amount=1;
            $services = [];
            foreach ($selectedServices as $service) {
                $price = $serviceRepository->find($service)->getPrice();
                $amount = $amount * $price;
                array_push($services, $serviceRepository->find($service)->getName());
            }
            $user=$this->getUser();

            if ($user instanceof User) {
                $id=$user->getId();
            }
            $quote->setUser($userRepository->find($id));
            $quote->setType($type);
            $quote->setServices($services);
            $quote->setAmount($amount);
            $entityManager->persist($quote);
            $entityManager->flush();
            $user=$this->getUser();
            $flashy->success("Quote has been created");
if ($user instanceof User) {
    $id=$user->getId();
}
            return $this->redirectToRoute('app_user_quote_index'
            
            );
        }

        return $this->renderForm('quote/newtype.html.twig', [
            'quote' => $quote,
            'form' => $form,
            'questions' => $questions,
        ]);
    }

    #[Route('/{id}', name: 'app_quote_show', methods: ['GET'])]
    public function show(Quote $quote): Response
    {
        return $this->render('quote/show.html.twig', [
            'quote' => $quote,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quote_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quote $quote, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_quote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quote/edit.html.twig', [
            'quote' => $quote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quote_delete', methods: ['POST'])]
    public function delete(Request $request, Quote $quote, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quote->getId(), $request->request->get('_token'))) {
            $entityManager->remove($quote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quote_index', [], Response::HTTP_SEE_OTHER);
    }



    
    #[Route('/print/{id}', name: 'app_quote_print')]
    public function print($id,QuoteRepository $quoteRepository,QuestionRepository $questionRepository):void
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont','Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled',true);
        $dompdf = new Dompdf($pdfOptions);
        $date = date("Y/m/d");
        $quote = $quoteRepository->find($id);
        $questions = $questionRepository->findByType($quote->getType());
        $firstName = $quote->getUser()->getLastName();
        $lastname = $quote->getUser()->getFirstName();
        $html = $this->renderView('quote/print.html.twig',[
            'id' => $id,
            'date' => $date,
            'quote' => $quote,
            'firstName' => $firstName ,
            'lastName'=>$lastname, 
            'questions'=>$questions,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (force download)
        $dompdf->stream('devis.pdf',["Attachment" => true]);    

     
    }

    #[Route('/mail/{id}', name: 'app_quote_mail', methods: ['GET'])]
    public function sendEmail($id,MailerInterface $mailer,FlashyNotifier $flashy,QuoteRepository $quoteRepository,QuestionRepository $questionRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont','Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled',true);
        $dompdf = new Dompdf($pdfOptions);
        $date = date("Y/m/d");
        $quote = $quoteRepository->find($id);
        $questions = $questionRepository->findByType($quote->getType());
        $firstName = $quote->getUser()->getLastName();
        $lastname = $quote->getUser()->getFirstName();
        $email = $quote->getUser()->getEmail();
        $html = $this->renderView('quote/print.html.twig',[
            'id' => $id,
            'date' => $date,
            'quote' => $quote,
            'firstName' => $firstName ,
            'lastName'=>$lastname, 
            'questions'=>$questions,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();


        $email = (new Email())
            ->from('oussemaa782@gmail.com')
            ->to($email)
            ->subject("Quote")
            ->text("hello , this is your quote")
            ->attach($dompdf->output(),"devis");

        $mailer->send($email);
        $flashy->success("Email sent !");
        return $this->redirectToRoute('app_quote_show',['id' => $id]);
    }


    
}
