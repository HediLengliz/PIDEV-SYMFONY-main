<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use App\Repository\SinisterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TwilioService; // Add this use statement
use Knp\Component\Pager\PaginatorInterface;
use App\Service\PdfService;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    private $twilioService;

   
    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    #[Route('/', name: 'app_rapport_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, RapportRepository $rapportRepository, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $rapportRepository->findAll(),
            $request->query->getInt('page', 1), // Get the page number from the request
            5 // Number of items per page
        );
        return $this->render('rapport/index.html.twig', [
            'rapports' => $pagination,
        ]);
    }

    #[Route('/new/{id}', name: 'app_rapport_new', methods: ['GET', 'POST'])]
    public function new($id,Request $request, EntityManagerInterface $entityManager, SinisterRepository $sinisterRepository): Response
    {
        $rapport = new Rapport();
        $rapport->setSinisterRapport($sinisterRepository->find($id));
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rapport);
            $entityManager->flush();

            // Fetch the associated Sinister
            $sinister = $sinisterRepository->find($id);

            // Check if Sinister is present and set its status to "traité"
            if ($sinister) {
                $sinister->setStatusSinister('traité');
                $entityManager->flush();
                //$userPhoneNumber = $sinister->getSinisterUser()->getPhoneNumber();
                //$countryCode = '+216';
                //$fullPhoneNumber = $countryCode . $userPhoneNumber;

                // Send the SMS
                // $this->twilioService->sendSms(
                //     $fullPhoneNumber,
                //     'Your Sinister has been treated successfully! Thank you for using our service.'
                // );
            }

            return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_rapport_show_admin', methods: ['GET'])]
    public function showAdmin($id,Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        
        $rapportRepository->find($id);
        return $this->render('rapport/showAdmin.html.twig', [
            'rapport' => $rapport,
        ]);
    }
    
    #[Route('/showrapporthh/{id}', name: 'app_rapport_showhh', methods: ['GET'])]
    public function showaa($id, RapportRepository $rapportRepository, SinisterRepository $sinisterRepository): Response
    {
        // Retrieve the SinisterProperty based on the provided ID
        $sinisterProperty = $sinisterRepository->find($id);
    
        // Check if SinisterProperty exists
        if (!$sinisterProperty) {
            throw $this->createNotFoundException('SinisterProperty not found');
        }
    
        // Retrieve the associated Rapport
        $rapport = $rapportRepository->findOneBy(['SinisterRapport' => $sinisterProperty]);
    
        // Check if Rapport exists
        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found for the given SinisterProperty');
        }
    
        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_rapport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    
    #[Route('/{id}', name: 'app_rapport_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rapport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/pdf/{id}', name: 'rapport.pdf')]
public function generatePdfPersonne(Rapport $rapport = null, PdfService $pdf) {
    $html = $this->render('rapport/showPdf.html.twig', ['rapport' => $rapport]);
    $pdf->showPdfFile($html);
    return new RedirectResponse($this->generateUrl('app_rapport_show', ['id' => $rapport->getId()]));

}

}
