<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Form\ListingType;
use App\Repository\CategoryRepository;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ListingController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('listing/index.html.twig', [
            'controller_name' => 'ListingController',
        ]);
    }

    public function create(Request $request, CategoryRepository $categoryRepository): Response
    {
        $listing = new Listing();


        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request); // This line is causing  an error

        if($form->isSubmitted() && $form->isValid()) {

        }

        $categories = $categoryRepository->getAllCategories();
        return $this->render('listing/create.html.twig', [
            'listingForm' => $form->createView(),
            'categories' => $categories
        ]);
    }

    public function userListings(TokenStorageInterface $tokenStorage, ListingRepository $listingRepository): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        if(!$user) {
            return $this->redirectToRoute('not_found');
        }

        $listings = $listingRepository->getUserListings($user->getId());
//        dd($listings);

        return $this->render('listing/user_listing.html.twig', [
            'listings' => $listings
        ]);
    }

    public function deleteListing(Listing $listing, ListingRepository $listingRepository) : Response
    {
        $listingRepository->remove($listing, true);
        $this->addFlash('success', 'Listing removed successfully.');
       return $this->redirectToRoute('user_listings');
    }
}
