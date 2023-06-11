<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Form\ListingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('listing/index.html.twig', [
            'controller_name' => 'ListingController',
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $listing = new Listing();
        $listing->setCreatedAt(new \DateTimeImmutable()); // Set the created_at value here
        $listing->setUpdatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $listing->setCreatedAt(new \DateTimeImmutable());
            $listing->setUpdatedAt(new \DateTimeImmutable());


            dd('submitted');
        }

        return $this->render('listing/create.html.twig', [
            'listingForm' => $form->createView()
        ]);
    }
}
