<?php

namespace App\Controller;

use App\Event\UserRegisteredEvent;
use App\Form\RegistrationFormType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class RegisterController extends AbstractController
{



    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() ) {

            // Create a new user entity and set its properties based on the form data
            $user = new User();

            $user->setName($form->get('name')->getData());
            $user->setEmail($form->get('email')->getData());

            // Hash the user's password
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hashedPassword);

            $dateTime = new \DateTimeImmutable();
            $user->setCreatedAt($dateTime);
            $user->setUpdatedAt($dateTime);

            // Persist the user entity to the database
            $entityManager->persist($user);
            $entityManager->flush();

            // Flash a success message to the user
            $this->addFlash('success', 'You have successfully registered!. Please login now.');
            $event = new UserRegisteredEvent(['email' => $user->getEmail(), 'name' => $user->getName()]);
            $eventDispatcher->dispatch($event);


            // Redirect the user to a different page after successful registration
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);

    }

//    #[Route('/register', name: 'app_register')]
    public function index(): Response
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }
}
