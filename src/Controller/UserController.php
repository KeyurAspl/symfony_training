<?php

namespace App\Controller;

use App\Form\LanguageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends AbstractController
{
    public function profile(Request $request, Session $session, string $defaultFallbackLocale): Response
    {
        $form = $this->createForm(LanguageType::class, [
            'language' => $session->get('_locale', $defaultFallbackLocale)
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $language = $form->getData()['language'];
            $request->getSession()->set('_locale', $language);

            $this->addFlash('success', 'Language has been changed to '.$language);
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
