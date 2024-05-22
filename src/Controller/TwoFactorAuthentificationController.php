<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwoFactorAuthentificationController extends AbstractController
{
    #[Route('/two/factor/authentification', name: 'app_two_factor_authentification')]
    public function index(Request $request): Response
    {
        // Check if the user completed the first factor
        if (!$request->getSession()->get('2fa_authenticated')) {
            return $this->redirectToRoute('app_login'); // Redirect to homepage or login page
        }

        // Handle the second factor authentication form submission
        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');

            // Retrieve the stored code from the session
            $storedCode = $request->getSession()->get('authentication_code');

            // Check if the entered code matches the stored code
            if ($code == $storedCode) {
                // Code is correct, you can proceed with user authentication
                // Redirect to the profile page or perform any other action
                if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_EXPERT') || $this->isGranted('ROLE_AGENT')) {
                    // Redirect to admin profile
                    return $this->redirectToRoute('admin_profile');
                } elseif ($this->isGranted('ROLE_USER')) {
                    // Redirect to user profile
                    return $this->redirectToRoute('profile');
                }            } else {
                // Code is incorrect, display an error message
                $this->addFlash('danger', 'Invalid code. Please try again.');
            }
        }

        // Render the 2FA code entry form
        return $this->render('security/twofactors.html.twig');
    }
}
