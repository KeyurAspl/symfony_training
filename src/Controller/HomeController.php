<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     * Getting data with entity
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     * Getting Data with repository
     */
    public function index2(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->getAllCategories();

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
