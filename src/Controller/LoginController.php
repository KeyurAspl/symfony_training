<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class LoginController extends AbstractController
{
    public function index(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        if ($security->getUser()) {
            // User is already authenticated, redirect to the home page or any desired page
            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    public function logout(): RedirectResponse
    {
        // Optional: Perform any additional logout-related tasks here

        throw new \LogicException('This method should not be called directly.');
    }
}
