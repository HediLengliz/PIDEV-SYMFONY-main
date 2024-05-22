<?php

namespace App\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(SessionInterface $session,PaginatorInterface $paginator, Request $request,ReclamationRepository $reclamationRepository,UserRepository $userRepository): Response
{
    // if (!$request->getSession()->get('2fa_authenticated')) {
    //     // Manually set the session variable to false
    //     $session->set('2fa_authenticated', false);

    //     // Manually clear the user's security token
    //     $this->get('security.token_storage')->setToken(null);

    //     // Redirect to the logout route, which will handle the logout and then redirect to login
    //     return $this->redirectToRoute('app_logout');
    // }
    $user=$this->getUser();
    if (!$userRepository->canRead($this->getUser(),'reclamation')) {
        return $this->errorUnothorized(); // Fix the spelling here
    }
    $permissions = [
        'canRead' => $userRepository->canRead($user, 'reclamation'), // Replace 'entity_name' with your actual entity name
        'canUpdate' => $userRepository->canUpdate($user, 'reclamation'),
        'canDelete' => $userRepository->canDelete($user, 'reclamation'),
        'canCreate' => $userRepository->canCreate($user, 'reclamation'),
    ];
    $reclamations = $reclamationRepository->findAll();
    $reclamationsWithUserCin = [];

    // Adjust the loop to add 'cin' to each reclamation row
    foreach ($reclamations as $reclamation) {
        $userCin = $reclamation->getUser()->getCin();
        $reclamationsWithUserCin[] = [
            'reclamation' => $reclamation,
            'userCin' => $userCin,
        ];
    }
    $pagination = $paginator->paginate(
        $reclamationsWithUserCin,
        $request->query->getInt('page', 1), // Get the page number from the request
        5 // Number of items per page
    );
    return $this->render('reclamation/index.html.twig', [
        'reclamationsWithUserCin' => $pagination,
        'permissions' => $permissions,
    ]);
}




    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(FlashyNotifier $flashy,Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setDateReclamation(new \DateTime());

        $user = $this->getUser(); // Use $this->getUser() to get the authenticated user
    
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
    
        if ($user instanceof \App\Entity\User) {
            // Assuming your User entity has a method getId()
            
    
            // Redirect to the 'app_reclamation_index' route with the user ID as a query parameter
            if ($form->isSubmitted() && $form->isValid()) {
                $reclamation->setUser($user);
                $entityManager->persist($reclamation);
                $entityManager->flush();
                $flashy->success('success','reclamation added successfully');
                return $this->redirectToRoute('app_reclamation_show', [], Response::HTTP_SEE_OTHER);
            }
        }
    
        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
public function containsBadWords(string $text): bool
{
    $api_key = 'YOUR_WEBPURIFY_API_KEY';
    $endpoint = 'https://api.webpurify.com/services/rest/';
    $method = 'webpurify.live.check';

    $params = [
        'api_key' => $api_key,
        'method' => $method,
        'text' => $text,
    ];

    $response = file_get_contents($endpoint . '?' . http_build_query($params));
    $result = json_decode($response, true);

    return $result['rsp']['found'] == '1';
}
    #[Route('/userReclamation', name: 'app_reclamation_show')]
    public function show(SessionInterface $session,PaginatorInterface $paginator, Request $request,EntityManagerInterface $entityManager): Response
    {
        // if (!$request->getSession()->get('2fa_authenticated')) {
        //     // Manually set the session variable to false
        //     $session->set('2fa_authenticated', false);
    
        //     // Manually clear the user's security token
        //     $this->get('security.token_storage')->setToken(null);
    
        //     // Redirect to the logout route, which will handle the logout and then redirect to login
        //     return $this->redirectToRoute('app_logout');
        // }
        // Get the currently logged-in user
        $user = $this->getUser();
        
        if ($user instanceof \App\Entity\User) {
            $reclamations = $entityManager->createQueryBuilder()
            ->select('r.id', 'r.title', 'r.description','r.dateReclamation') // Include only the necessary fields
            ->from('App\Entity\Reclamation', 'r')
            ->where('r.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        }
        // Assuming there's a property or method in the User entity that represents the reclamations
        $pagination = $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1), // Get the page number from the request
            5 // Number of items per page
        );
        return $this->render('reclamation/show.html.twig', [
            'reclamations' => $pagination,
        ]);
    }
    #[Route('/{id}', name: 'adminreclamation', methods: ['GET'])]
    public function admingetUserReclamation(Reclamation $reclamation): Response
    {
        // Get the currently logged-in user
        $user = $this->getUser();
    
        // Check if the reclamation belongs to the logged-in user
        if (!$this->isGranted('ROLE_ADMIN') && $user !== $reclamation->getUser()) {
            // Throw an AccessDeniedException or handle it as needed
            throw new AccessDeniedException('Access denied: This reclamation does not belong to the current user.');
        }
    
        return $this->render('reclamation/showreclamation2.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    #[Route('/clientreclamation/{id}', name: 'reclamation', methods: ['GET'])]
    public function getUserReclamation(Reclamation $reclamation): Response
    {
        // Get the currently logged-in user
        $user = $this->getUser();
    
        // Check if the reclamation belongs to the logged-in user
    
    
        return $this->render('reclamation/showreclamation.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    public function errorUnothorized()
    {
        return $this->render('errors/unothorized.html.twig', [
            
        ]);
    }
    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(UserRepository $userRepository,Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            // if (!$userRepository->canDelete($this->getUser(),'reclamation')) {
            //     return $this->errorUnothorized(); // Fix the spelling here
            // }
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_show', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/delete/{id}', name: 'admin_reclamation_delete', methods: ['POST'])]
    public function admindeletereclamation(UserRepository $userRepository,Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            // if (!$userRepository->canDelete($this->getUser(),'reclamation')) {
            //     return $this->errorUnothorized(); // Fix the spelling here
            // }
            $entityManager->remove($reclamation);
            $entityManager->flush();
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
