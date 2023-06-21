<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function getAjaxCategories(EntityManagerInterface $entityManager): Response
    {
        return $this->render('components/component-categories.twig', [
            'categories' => $entityManager->getRepository(Category::class)->findAll() ?? []
        ]);
    }

    public function getCategoryListings(CategoryRepository $categoryRepository, int $category)
    {
        $category = $categoryRepository->find($category);

        if (!$category) {
            return $this->redirectToRoute('not_found');
        }

        $listings = $category->getListings();
        return $this->render('listing/category_listing.html.twig', [
            'category' => $category,
            'listings' => $listings
        ]);
    }

}
