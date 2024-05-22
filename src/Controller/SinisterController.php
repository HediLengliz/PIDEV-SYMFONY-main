<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sinister;
use App\Repository\SinisterRepository;
use App\Repository\UserRepository;



class SinisterController extends AbstractController
{
    #[Route('/details/{id}', name: 'sinister_details', methods: ['GET'])]
    public function details($id): Response
    {
        // Fetch the Sinister based on $id
        $sinister = $this->getDoctrine()->getRepository(Sinister::class)->find($id);

        if (!$sinister) {
            // Handle the case where the Sinister with the given $id is not found
            throw $this->createNotFoundException('Sinister not found for id ' . $id);
        }

        // Determine the type of Sinister and render accordingly
        $template = match (true) {
            $sinister instanceof \App\Entity\SinisterVehicle => 'constat/details.html.twig',
            $sinister instanceof \App\Entity\SinisterProperty => 'sinister_property/details.html.twig',
            default => 'sinister/details.html.twig',
        };

        return $this->render($template, [
            'sinister' => $sinister,
        ]);
    }


    public function userdetails($id): Response
    {
        // Fetch the Sinister based on $id

        $sinister = $this->getDoctrine()->getRepository(Sinister::class)->find($id);

        if (!$sinister) {
            // Handle the case where the Sinister with the given $id is not found
            throw $this->createNotFoundException('Sinister not found for id ' . $id);
        }

        // Determine the type of Sinister and render accordingly
        $template = match (true) {
            $sinister instanceof \App\Entity\SinisterVehicle => 'constat/details.html.twig',
            $sinister instanceof \App\Entity\SinisterProperty => 'sinister_property/details.html.twig',
            default => 'sinister/details.html.twig',
        };

        return $this->render($template, [
            'sinister' => $sinister,
        ]);
    }
    #[Route('/user/sinisters/{staticUserId}', name: 'user_sinisters')]
    public function userSinisters(SinisterRepository $sinisterRepository, UserRepository $userRepository, int $staticUserId): Response
    {
        // Fetch the user based on the static ID
        $user = $userRepository->find(10);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Fetch sinisters for the user
        $sinisters = $sinisterRepository->findByUser($user);

        return $this->render('sinister/user_sinister.html.twig', [
            'sinisters' => $sinisters,
        ]);
    }

}
