<?php

namespace App\Controller;

use App\Entity\MedicalSheet;
use App\Entity\Prescription;
use App\Entity\SinisterLife;
use App\Form\MedicalSheetType;
use App\Form\PrescriptionType;
use App\Form\SinisterLifeType;
use App\Repository\MedicalSheetRepository;
use App\Repository\PrescriptionRepository;
use App\Repository\SinisterLifeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
  
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('admin/sidebar.html.twig');
    }
    #[Route('/showSinisterLifeAdmin', name: 'app_sinister_life_dashboard', methods: ['GET'])]
    public function showSinisterLifeAdmin(SinisterLifeRepository $sinisterLifeRepository): Response
    {
        return $this->render('admin/showSLadmin.html.twig', [
            'sinister_lives' => $sinisterLifeRepository->findAll(),
        ]);
    }
    #[Route('/showMedicalSheetsAdmin', name: 'app_medical_sheet_dashboard', methods: ['GET'])]
    public function showMedicalSheetsAdmin(MedicalSheetRepository $medicalSheetRepository): Response
    {
        return $this->render('admin/showMSadmin.html.twig', [
            'medical_sheets' => $medicalSheetRepository->findAll(),
        ]);
    }

    #[Route('/showPrescriptionsAdmin', name: 'app_prescription_dashboard', methods: ['GET'])]
    public function showPrescriptionsAdmin(PrescriptionRepository $prescriptionRepository): Response
    {
        return $this->render('admin/showPadmin.html.twig', [
            'prescriptions' => $prescriptionRepository->findAll(),
        ]);
    }


    #[Route('/sinister/life/{id}', name: 'app_sinister_life_show_dashboard', methods: ['GET'])]
    public function show(SinisterLife $sinisterLife): Response
    {
        return $this->render('admin/viewSingleSLadmin.html.twig', [
            'sinister_life' => $sinisterLife,
        ]);
    }

    #[Route('/medical-sheet/{id}', name: 'app_medical_sheet_show_dashboard', methods: ['GET'])]
    public function showMS(MedicalSheet $medicalSheet): Response
    {
        return $this->render('admin/viewSingleMSadmin.html.twig', [
            'medical_sheet' => $medicalSheet,
        ]);
    }

    #[Route('/prescription_/{id}', name: 'app_prescription_show_dashboard', methods: ['GET'])]
    public function showP(Prescription $prescription): Response
    {
        return $this->render('admin/viewSinglePadmin.html.twig', [
            'prescription' => $prescription,
        ]);
    }


    #[Route('/prescription_/{id}/edit', name: 'app_prescription_edit_dashboard', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prescription $prescription, EntityManagerInterface $entityManager): Response
    {
        // Clone the original entity to compare later
        $originalData = clone $prescription;

        $form = $this->createForm(PrescriptionType::class, $prescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Compute changes using Doctrine's UnitOfWork
            $uow = $entityManager->getUnitOfWork();
            $uow->computeChangeSets(); // Calculate the changes

            $changes = $uow->getEntityChangeSet($prescription);

            if (count($changes) > 0) {
                // Changes detected, flush and show a success message
                $entityManager->flush();
                $this->addFlash('success', 'Prescription updated successfully.');
            } else {
                // No changes detected, show a warning message
                $this->addFlash('warning', 'No changes have been made, Please update befor submitting.');
            }

            return $this->redirectToRoute('app_prescription_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/editSinglePadmin.html.twig', [
            'prescription' => $prescription,
            'form' => $form,
        ]);
    }

    #[Route('/medicalsheet/{id}/edit', name: 'app_medical_sheet_edit_dashboard', methods: ['GET', 'POST'])]
    public function editMS(Request $request, MedicalSheet $medicalSheet, EntityManagerInterface $entityManager): Response
    {
        $originalData = clone $medicalSheet;
        $form = $this->createForm(MedicalSheetType::class, $medicalSheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Compute changes
            $uow = $entityManager->getUnitOfWork();
            $uow->computeChangeSets(); // Calculate the changes

            $changes = $uow->getEntityChangeSet($medicalSheet);

            if (count($changes) > 0) {
                // If there are changes, flush and show success message
                $entityManager->flush();
                $this->addFlash('success', 'Medical Sheet updated successfully.');
            } else {
                // If no changes, show warning message
                $this->addFlash('warning', 'No changes have been made, Please update before submitting.');
            }

            return $this->redirectToRoute('app_medical_sheet_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/editSingleMSadmin.html.twig', [
            'medical_sheet' => $medicalSheet,
            'form' => $form,
        ]);
    }

    #[Route('/sinister/life/{id}/edit', name: 'app_sinister_life_edit_dashboard', methods: ['GET', 'POST'])]
    public function editS(Request $request, SinisterLife $sinisterLife, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(SinisterLifeType::class, $sinisterLife);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->getUnitOfWork()->computeChangeSets();

            $changes = $entityManager->getUnitOfWork()->getEntityChangeSet($sinisterLife);

            if (count($changes) > 0) {

                $entityManager->flush();
                $this->addFlash('success', 'SinisterLife updated successfully.');
            } else {
                $this->addFlash('warning', 'No changes have been made.');
            }

            return $this->redirectToRoute('app_sinister_life_dashboard');
        }

        return $this->renderForm('admin/editSingleSLadmin.html.twig', [
            'sinister_life' => $sinisterLife,
            'form' => $form,
        ]);
    }

    private function isSinisterLifeModified(SinisterLife $original, SinisterLife $updated): bool
    {
        $changesDetected = $original->getDateSinister() !== $updated->getDateSinister()
            || $original->getLocation() !== $updated->getLocation()
            || $original->getAmountSinister() !== $updated->getAmountSinister()
            || $original->getStatusSinister() !== $updated->getStatusSinister()
            || $original->getDescription() !== $updated->getDescription()
            || $original->getBeneficiaryName() !== $updated->getBeneficiaryName();

        if (!$changesDetected) {
            dump('No changes detected.');
        } else {
            dump('Changes detected.');
        }

        return $changesDetected;
    }



    #[Route('/{id}/validate', name: 'app_sinister_life_validate', methods: ['POST'])]
    public function validate(Request $request, SinisterLife $sinisterLife, EntityManagerInterface $entityManager, MailerInterface $mailer, LoggerInterface $logger): Response {
        if ($sinisterLife->getStatusSinister() === 'ongoing') {
            $sinisterLife->setStatusSinister('processed');
            $entityManager->flush();
            $this->addFlash('success', 'Sinister Life has been validated.');

            // Log before sending the email
            $logger->info('Sending validation email to: ' . $sinisterLife->getSinisterUser()->getEmail());

            // Prepare the email
            $email = (new Email())
                ->from('oussemaa782@gmail.com')
                ->to($sinisterLife->getSinisterUser()->getEmail())
                ->subject('Sinister Life Validation')
                ->html('<p>Your Sinister Life has been validated.</p>');

            // Send the email
            $mailer->send($email);

            // Log after sending the email
            $logger->info('Email sent to: ' . $sinisterLife->getSinisterUser()->getEmail());
        } else {
            $this->addFlash('error', 'Sinister Life cannot be validated.');
        }

        return $this->redirectToRoute('app_sinister_life_dashboard');
    }

    #[Route('/{id}/confirm-validate', name: 'app_sinister_life_confirm_validate', methods: ['GET', 'POST'])]
    public function confirmValidate(Request $request, SinisterLife $sinisterLife): Response {
        // Render a confirmation page
        return $this->render('admin/confirm_validate.html.twig', [
            'sinister_life' => $sinisterLife,
        ]);
    }

    #[Route('/{id}/refuse', name: 'app_sinister_life_refuse', methods: ['POST'])]
    public function refuse(Request $request, SinisterLife $sinisterLife, EntityManagerInterface $entityManager, MailerInterface $mailer, LoggerInterface $logger): Response {
        if ($sinisterLife->getStatusSinister() === 'ongoing') {
            $sinisterLife->setStatusSinister('closed');
            $entityManager->flush();
            $this->addFlash('success', 'Sinister Life has been refused.');

            // Log before sending the email
            $logger->info('Sending refusing email to: ' . $sinisterLife->getSinisterUser()->getEmail());

            // Prepare the email
            $email = (new Email())
                ->from('oussemaa782@gmail.com')
                ->to($sinisterLife->getSinisterUser()->getEmail())
                ->subject('Sinister Life Refusal Notification ')
                ->html('<p>Your Sinister Life has been refused, for more information contact us .</p>');

            // Send the email
            $mailer->send($email);

            // Log after sending the email
            $logger->info('Email sent to: ' . $sinisterLife->getSinisterUser()->getEmail());
        } else {
            $this->addFlash('error', 'Sinister Life cannot be refused.');
        }

        return $this->redirectToRoute('app_sinister_life_dashboard');
    }

    #[Route('/{id}/confirm-refuse', name: 'app_sinister_life_confirm_refuse', methods: ['GET', 'POST'])]
    public function confirmRefuse(Request $request, SinisterLife $sinisterLife): Response {

        return $this->render('admin/confirm_refuse.html.twig', [
            'sinister_life' => $sinisterLife,
        ]);
    }

}
