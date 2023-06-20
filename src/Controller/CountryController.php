<?php

namespace App\Controller;

use App\Form\SelectCountryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{


    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(SelectCountryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCity = $form->get('city')->getData();

            // Process the selected city
            // For example, you can persist the selected city to the database
            $entityManager->persist($selectedCity);
            $entityManager->flush();

            // Redirect or render a response
            return $this->redirectToRoute('home');
        }



        return $this->render('country/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
