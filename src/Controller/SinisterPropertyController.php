<?php

namespace App\Controller;

use App\Entity\SinisterProperty;
use App\Form\SinisterPropertyType;
use App\Repository\SinisterPropertyRepository;
use App\Entity\Rapport;
use App\Repository\SinisterRepository;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/sinister/property')]
class SinisterPropertyController extends AbstractController
{
    #[Route('/', name: 'app_sinister_property_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator , SinisterPropertyRepository $sinisterPropertyRepository, RapportRepository $rapportRepository, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $sinisterPropertyRepository->findAll(),
            $request->query->getInt('page', 1), // Get the page number from the request
            5 // Number of items per page
        );
        return $this->render('sinister_property/index.html.twig', [
            'sinister_properties' =>   $pagination,
            'rapport' =>  $rapportRepository->findAll()
        ]);
    }
    #[Route('/user/show/sp', name: 'app_prop_show_paruser', methods: ['GET'])]
    public function showParUser(SinisterPropertyRepository $req): Response
    {
        $user=$this->getUser();
        if ($user instanceof User){
            // dd($user);
            $requ=$req->findBy(['sinisterUser'=>$user->getId()]);
            
        }
       
        return $this->render('sinister_property/userRequest.html.twig', [
            'sinister_properties' => $requ,
        ]);
    }
    
    #[Route('/usersinistre/{userId}', name: 'app_user_sinister', methods: ['GET', 'POST'])]

    public function sinistresByUser(SinisterRepository $sinistreRepository, $userId): Response
    {
        $sinistres = $sinistreRepository->findByUserId($userId);
        // Do something with the $sinistres, like passing it to a template or returning a JSON response.

        return $this->render('sinister_property/indexC.html.twig', [
            'sinister_properties' => $sinistres,
        ]);
    }
    #[Route('/new', name: 'app_sinister_property_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SinisterPropertyRepository $sinisterPropertyRepository): Response
    {
        // Fetch the user based on the static ID
        $user=$this->getUser();
        if ($user instanceof User) {
            $id=$user->getId();
        }
        $staticUserId = $id; // Replace with the actual static user ID
        $user = $this->getDoctrine()->getRepository(User::class)->find($staticUserId);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $sinisterProperty = new SinisterProperty();
        $sinisterProperty->setSinisterUser($user); // Associate the user with the SinisterProperty

        $form = $this->createForm(SinisterPropertyType::class, $sinisterProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sinisterProperty);
            $entityManager->flush();

            $message = "Votre déclaration de sinistre habitation a été enregistrée. Un expert la traitera et vous contactera pour plus d'informations.";
                $this-> addFlash('success',$message);
                return $this->redirectToRoute('app_prop_show_paruser', [], Response::HTTP_SEE_OTHER);
            // return $this->render('sinister_property/indexC.html.twig', [
            //     'message' => $message,
            //     'sinister_properties' => $sinisterPropertyRepository->findAll(),
            // ]);
        }

        return $this->renderForm('sinister_property/new.html.twig', [
            'sinister_property' => $sinisterProperty,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_sinister_property_show', methods: ['GET'])]
    public function showAdmin(SinisterProperty $sinisterProperty): Response
    {
        return $this->render('sinister_property/show.html.twig', [
            'sinister_property' => $sinisterProperty,
        ]);
    }


    #[Route('/{id}', name: 'app_sinister_property_show_admin', methods: ['GET'])]
    public function show(SinisterProperty $sinisterProperty): Response
    {
        
        return $this->render('sinister_property/show_admin.html.twig', [
            'sinister_property' => $sinisterProperty,
          
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sinister_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SinisterProperty $sinisterProperty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SinisterPropertyType::class, $sinisterProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

           
            $message = "Votre modification a été enregistrée. Un expert la traitera et vous contactera pour plus d'informations.";
            $this-> addFlash('success',$message);
         
            return $this->redirectToRoute('app_prop_show_paruser', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sinister_property/edit.html.twig', [
            'sinister_property' => $sinisterProperty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sinister_property_delete', methods: ['POST'])]
    public function delete(Request $request, SinisterProperty $sinisterProperty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sinisterProperty->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sinisterProperty);
            $entityManager->flush();
            $message = "Votre sinistre a été supprimé. ";
    

            $this-> addFlash('success',$message);
         
            return $this->redirectToRoute('app_prop_show_paruser', [], Response::HTTP_SEE_OTHER);
        }

        
        }

       
    }

