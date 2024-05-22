<?php

namespace App\Controller;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\EmailService;
use Symfony\Component\Filesystem\Filesystem;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\User;
use App\Form\ProfilePictureType;
use App\Form\UpdateUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\DatabaseService;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
   private DatabaseService $d;

   #[Route('/sendSms', name: 'send_sms', methods:'POST')]
   public function sendSms(Request $request, TwilioService $smsGenerator): Response
   {
      
// Numéro vérifier par twilio. Un seul numéro autorisé pour la version de test.

       //Appel du service
       $smsGenerator->sendSms('+21692741748' ,'oussema');

       return $this->json(['smsSent'=>true]);
   }

   #[Route('/', name: 'app_user_index', methods: ['GET'])]
   public function index(SessionInterface $session,UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
   {
       try {
        // if (!$request->getSession()->get('2fa_authenticated')) {
        //     // Manually set the session variable to false
        //     $session->set('2fa_authenticated', false);
    
        //     // Manually clear the user's security token
        //     $this->get('security.token_storage')->setToken(null);
    
        //     // Redirect to the logout route, which will handle the logout and then redirect to login
        //     return $this->redirectToRoute('app_logout');
        // }
           $user = $this->getUser(); // Get the currently logged-in user
           if (!$userRepository->canRead($this->getUser(), 'user')) {
               return $this->errorUnothorized(); // Fix the spelling here
           }
            
           // Fetch all users from the repository
           $allUsers = $userRepository->findAll();
   
           // Paginate the results
           $pagination = $paginator->paginate(
               $allUsers,
               $request->query->getInt('page', 1), // Get the page number from the request
               5 // Number of items per page
           );
   
           // Check and store the permissions for the logged-in user
           $permissions = [
               'canRead' => $userRepository->canRead($user, 'user'),
               'canUpdate' => $userRepository->canUpdate($user, 'user'),
               'canDelete' => $userRepository->canDelete($user, 'user'),
               'canCreate' => $userRepository->canCreate($user, 'user'),
           ];
   
           return $this->render('user/index.html.twig', [
               'users' => $pagination,
               'permissions' => $permissions,
           ]);
       } catch (AccessDeniedException $e) {
           // Redirect to the unauthorized page
           return new RedirectResponse($this->generateUrl('app_error_unothorized'));
       }
   }
    #[Route('/error', name: 'app_error_unothorized', methods: ['GET'])]

    public function errorUnothorized()
    {
        return $this->render('errors/unothorized.html.twig', [
            
        ]);
    }
    public function sendEmail(MailerInterface $mailer, $to, $subject, $text): Response
    {
        $email = (new Email())
            ->from('oussemaa782@gmail.com')
            ->to($to)
            ->subject($subject)
            ->text($text)
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
        return new Response("Email sent!");
    }
    public function generateRandomString($length = 10)
    {
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(EmailService $emailService, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {
        if (!$userRepository->canCreate($this->getUser(),'user')) {
            return $this->errorUnothorized(); // Fix the spelling here
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                if (!$userRepository->canCreate($this->getUser(),'user')) {
                    return $this->errorUnothorized(); // Fix the spelling here
                }
                $password = $this->generateRandomString();
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $password
                    )
                );
                $claims = $form->get('claims')->getData() ?? [];
                $entityManager->persist($user);
                $entityManager->flush();

                $email = $form->get('email')->getData();
                $subject = 'Protechtini credentials';
                $textString = "Email: $email<br>Password: $password";

                $emailService->sendEmail($user->getEmail(), $subject, $textString);

                $this->addFlash('success', 'User added successfully');
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }
        } catch (\Exception $e) {
            // Log or print the error message for debugging
            $this->addFlash('error', 'An error occurred: ' . $e->getMessage());
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/tables', name: 'app_db_table', methods: ['GET', 'POST'])]

    public function listTables(DatabaseService $yourClassService): Response
    {
        $allTables = $yourClassService->getAllTables();
        $filteredTables = array_filter($allTables, function ($table) {
            return $table !== 'messenger_messages';
        });
        foreach ($filteredTables as $tableKey => $tableName) {
            $choices[$tableName] = [
                'Can Create' => 'c',
                'Can Read' => 'r',
                'Can Update' => 'u',
                'Can Delete' => 'd',
            ];
        }
    
        return $this->json([$choices]);
    }
    #[Route('/table', name: 'app_db_role', methods: ['GET', 'POST'])]
    public function getRolesChoices(): array
    {
        $tables = $this->listTables($this->d);
        $choices = [];
    
        foreach ($tables as $tableKey => $tableName) {
            $choices[$tableName] = [
                'Can Create' => 'c_' . $tableName,
                'Can Read' => 'r_' . $tableName,
                'Can Update' => 'u_' . $tableName,
                'Can Delete' => 'd_' . $tableName,
            ];
        }
    
        return $choices;
    }
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(FlashyNotifier $flashy,UserRepository $userRepository,Request $request, User $user, EntityManagerInterface $entityManager): Response
    {if (!$userRepository->canUpdate($this->getUser(),'user')) {
        return $this->errorUnothorized(); // Fix the spelling here
    }
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->success('User updated successfully');

            // $this->addFlash('success',"User updated successfully");
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
   
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(UserRepository $userRepository,Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
           
            if (!$userRepository->canDelete($this->getUser(),'user')) {
                return $this->errorUnothorized(); // Fix the spelling here
            }
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
