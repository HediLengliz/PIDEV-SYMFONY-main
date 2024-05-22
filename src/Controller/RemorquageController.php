<?php

namespace App\Controller;

use App\Entity\Remorqueur;
use App\Service\TwilioService; // Add this use statement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RemorqueurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RemorquageController extends AbstractController
{
    #[Route('/remorquage', name: 'app_remorquage')]
    public function index(): Response
    {
        // Retrieve the list of remorqueurs from the database
        $remorqueurs = $this->getDoctrine()->getRepository(Remorqueur::class)->findAll();

        return $this->render('remorquage/map.html.twig', [
            'remorqueurs' => json_encode($this->serializeRemorqueurs($remorqueurs)),
        ]);
    }

  
    private function serializeRemorqueurs(array $remorqueurs): array
    {
        $data = [];

        foreach ($remorqueurs as $remorqueur) {
            $data[] = [
                'FirstName' => $remorqueur->getFirstName(),
                'LastName' => $remorqueur->getLastName(),
                'PhoneNumber' => $remorqueur->getPhoneNumber(),
                'lattitude' => $remorqueur->getLattitude(),
                'longuitude' => $remorqueur->getLonguitude(),
            ];
        }

        return $data;
    }

    /**
     * @Route("/flash-message", name="flash_message", methods={"POST"})
     */
    public function flashMessage(Request $request): JsonResponse
    {
        $type = $request->request->get('type');
        $message = $request->request->get('message');

        $this->addFlash($type, $message);

        return new JsonResponse(['status' => 'success']);
    }

}