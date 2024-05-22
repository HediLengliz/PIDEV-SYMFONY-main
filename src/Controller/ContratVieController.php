<?php

namespace App\Controller;
use App\Repository\LifeRequestRepository;
use App\Entity\LifeRequest;
use App\Service\PdfService;
use App\Service\TwilioService;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Entity\ContratVie;
use App\Form\ContratVieType;
use App\Repository\ContratVieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/contrat/vie')]
class ContratVieController extends AbstractController
{
 private $twilioService;


        public function __construct(TwilioService $twilioService)
        {
            $this->twilioService = $twilioService;
        }
    
    #[Route('/', name: 'app_contrat_vie_index', methods: ['GET'])]
    public function index(ContratVieRepository $contratVieRepository): Response
    {
        return $this->render('contrat_vie/index.html.twig', [
            'contrat_vies' => $contratVieRepository->findAll(),
        ]);
    }
    #[Route('/contrat/UserLife', name: 'app_contrat_vie_user', methods: ['GET'])]
    public function abc(ContratVieRepository $contratVieRepository): Response
    {
        return $this->render('life_request/showContrat.html.twig', [
            'contrat_vie' => $contratVieRepository->findAll()[count($contratVieRepository->findAll())-1],
        ]);
    }

    #[Route('/New_ContratVie', name: 'app_contrat_vie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contratVie = new ContratVie();
        $form = $this->createForm(ContratVieType::class, $contratVie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contratVie);
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_vie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat_vie/new.html.twig', [
            'contrat_vie' => $contratVie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrat_vie_show', methods: ['GET'])]
    public function show(ContratVie $contratVie): Response
    {
        return $this->render('contrat_vie/show.html.twig', [
            'contrat_vie' => $contratVie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrat_vie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContratVie $contratVie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratVieType::class, $contratVie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_vie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat_vie/edit.html.twig', [
            'contrat_vie' => $contratVie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrat_vie_delete', methods: ['POST'])]
    public function delete(Request $request, ContratVie $contratVie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contratVie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contratVie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contrat_vie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/showDemandes_vie', name: 'app_contrat_vie_show_in_contrat', methods: ['GET'])]
        public function showDemandes_vie(PaginatorInterface $paginator, LifeRequestRepository $lifeRequestRepository,  Request $request): Response
        {
             $pagination = $paginator->paginate(
              $lifeRequestRepository->findAll(),
             $request->query->getInt('page', 1),5 );
                return $this->render('contrat_vie/showDemandes.html.twig', [
                                        'life_requests' => $pagination,
                                      ]);

        }

         #[Route('/{id}/New_ContratVie', name: 'app_contrat_vie_newId', methods: ['GET', 'POST'])]
            public function newId(FlashyNotifier $flashy, Request $request, EntityManagerInterface $entityManager, LifeRequestRepository $lifeRequestRepository, $id): Response
            {
                $contratVie = new ContratVie();
                $form = $this->createForm(ContratVieType::class, $contratVie);
                $form->handleRequest($request);
                $data= $lifeRequestRepository->find($id) ;

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->persist($contratVie);
                    $entityManager->flush();
                        $demande = $contratVie->getRequest();
                        $flashy->success('Le contrat a été ajouté avec succes !');

                        if ($demande) {
                            $demande->setStatus('Accepter');
                            $entityManager->flush();
                        }
                     //    $this->twilioService->sendSms(
                       //                    +21652021389',
                         //                  'Votre contrat est pret. Veuillez terminer la procédure du paiement'
                           //                       );
                    return $this->redirectToRoute('app_contrat_vie_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->renderForm('contrat_vie/new.html.twig', [
                    'contrat_vie' => $contratVie,
                    'form' => $form,
                    'life_request' => $data
                ]);
            }
            #[Route('/pdf_vie/{id}', name: 'contrat_vie.pdf')]
                public function generatePdfPersonne(MailerInterface $mailer,ContratVie $contratVie = null, PdfService $pdf) {
                    $html = $this->render('contrat_vie/showPdf.html.twig', ['contrat_vie' => $contratVie]);
                    $pdfOptions = new Options();
                    $pdfOptions->set('defaultFont','Arial');
                    $pdfOptions->setIsRemoteEnabled(true);
                    $pdfOptions->set('isHtml5ParserEnabled',true);
                    $dompdf = new Dompdf($pdfOptions);
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4','portrait');
                    $dompdf->render();
                    $email = (new Email())
                    ->from('oussemaa782@gmail.com')
                    ->to("yasmine.said2001@gmail.com")
                    ->subject("Contrat")
                    ->text("hello , this is your contract")
                    ->attach($dompdf->output(),"contrat habitat");
            
                        $mailer->send($email);
                    return new RedirectResponse($this->generateUrl('app_contrat_vie_show', ['id' => $contratVie->getId()]));

                }

            #[Route('/refuser-demande-vie/{id}', name: 'refuser_demande_vie')]
            public function refuserDemande($id, EntityManagerInterface $entityManager, LifeRequestRepository $lifeRequestRepository): Response
            {
                $demande = $lifeRequestRepository->find($id);

                if (!$demande) {
                    throw $this->createNotFoundException('Demande non trouvée');
                }

                $demande->setStatus('Refusée');
                $entityManager->flush();

                    return $this->redirectToRoute('app_contrat_vie_show_in_contrat', [], Response::HTTP_SEE_OTHER);
            }

}
