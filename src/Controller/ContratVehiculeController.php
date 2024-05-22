<?php

namespace App\Controller;
use App\Repository\VehicleRequestRepository;
use App\Entity\VehicleRequest;
use App\Service\PdfService;
use App\Service\TwilioService;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Entity\ContratVehicule;
use App\Form\ContratVehiculeType;
use App\Repository\ContratVehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contrat;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/contrat/vehicule')]
class ContratVehiculeController extends AbstractController
{
 private $twilioService;


        public function __construct(TwilioService $twilioService)
        {
            $this->twilioService = $twilioService;
        }
    #[Route('/', name: 'app_contrat_vehicule_index', methods: ['GET'])]
    public function index(ContratVehiculeRepository $contratVehiculeRepository): Response
    {
        return $this->render('contrat_vehicule/index.html.twig', [
            'contrat_vehicules' => $contratVehiculeRepository->findAll(),
        ]);
    }
    #[Route('/userId', name: 'app_contrat_vehicule_user', methods: ['GET'])]
    public function abc(ContratVehiculeRepository $contratVehiculeRepository): Response
    {
        return $this->render('vehicle_request/ShowContrat.html.twig', [
            'contrat_vehicule' => $contratVehiculeRepository->findAll()[count($contratVehiculeRepository->findAll())-1]
        ]);
    }

    #[Route('/New_ContratVehicule', name: 'app_contrat_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
         $contratVehicule = new ContratVehicule();
            $form = $this->createForm(ContratVehiculeType::class, $contratVehicule);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $description = strip_tags($contratVehicule->getDescription());
                $contratVehicule->setDescription($description);
                $entityManager->persist($contratVehicule);
                $entityManager->flush();

                return $this->redirectToRoute('app_contrat_vehicule_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('contrat_vehicule/new.html.twig', [
                'contrat_vehicule' => $contratVehicule,
                'form' => $form,
            ]);
    }

    #[Route('/{id}', name: 'app_contrat_vehicule_show', methods: ['GET'])]
    public function show(ContratVehicule $contratVehicule): Response
    {
        return $this->render('contrat_vehicule/show.html.twig', [
            'contrat_vehicule' => $contratVehicule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrat_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContratVehicule $contratVehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratVehiculeType::class, $contratVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat_vehicule/edit.html.twig', [
            'contrat_vehicule' => $contratVehicule,
            'form' => $form,

        ]);
    }

    #[Route('/{id}', name: 'app_contrat_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, ContratVehicule $contratVehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contratVehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contratVehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contrat_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/showDemandes_vehicule', name: 'app_contrat_vehicule_show_in_contrat', methods: ['GET'])]
        public function showDemandes_vehicule(PaginatorInterface $paginator, VehicleRequestRepository $vehicleRequestRepository,  Request $request): Response
        {
                $pagination = $paginator->paginate(
                  $vehicleRequestRepository->findAll(),
                 $request->query->getInt('page', 1),5 );
                    return $this->render('contrat_vehicule/showDemandes.html.twig', [
                                            'vehicle_requests' => $pagination,
                                          ]);

        }

         #[Route('/{id}/New_ContratVehicule', name: 'app_contrat_vehicule_newId', methods: ['GET', 'POST'])]
            public function newId(FlashyNotifier $flashy, Request $request, EntityManagerInterface $entityManager, VehicleRequestRepository $vehicleRequestRepository, $id): Response
            {
                 $contratVehicule = new ContratVehicule();
                    $form = $this->createForm(ContratVehiculeType::class, $contratVehicule);
                    $form->handleRequest($request);
                    $data= $vehicleRequestRepository->find($id) ;


                    if ($form->isSubmitted() && $form->isValid()) {
                        $description = strip_tags($contratVehicule->getDescription());
                        $contratVehicule->setDescription($description);
                        $entityManager->persist($contratVehicule);
                        $entityManager->flush();
                        $demande = $contratVehicule->getRequest();
                        $flashy->success('Le contrat a été ajouté avec succes !');

                        if ($demande) {
                            $demande->setStatus('Accepter');
                            $entityManager->flush();
                        }
                                      //  $this->twilioService->sendSms(
                                        //    '+21652021389',
                                          //  'Votre contrat est pret. Veuillez terminer la procédure du paiement'
                                        //);
                        return $this->redirectToRoute('app_contrat_vehicule_index', [], Response::HTTP_SEE_OTHER);
                    }

                    return $this->renderForm('contrat_vehicule/new.html.twig', [
                        'contrat_vehicule' => $contratVehicule,
                        'form' => $form,
                        'vehicleRequest' =>$data
                    ]);
            }
             #[Route('/pdf_vehicule/{id}', name: 'contrat_vehicule.pdf')]
                public function generatePdfPersonne(MailerInterface $mailer,ContratVehicule $contratVehicule= null, PdfService $pdf) {
                    $html = $this->render('contrat_vehicule/showPdf.html.twig', ['contrat_vehicule' => $contratVehicule]);
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
        return new RedirectResponse($this->generateUrl('app_contrat_vehicule_show', ['id' => $contratVehicule->getId()]));

                }

#[Route('/refuser-demande/{id}', name: 'refuser_demande')]
public function refuserDemande($id, EntityManagerInterface $entityManager, VehicleRequestRepository $vehicleRequestRepository): Response
{
    $demande = $vehicleRequestRepository->find($id);

    if (!$demande) {
        throw $this->createNotFoundException('Demande non trouvée');
    }

    $demande->setStatus('Refusée');
    $entityManager->flush();

        return $this->redirectToRoute('app_contrat_vehicule_show_in_contrat', [], Response::HTTP_SEE_OTHER);
}

}
