<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\EmailNotifier;
use App\Service\RandomColorGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class TestController extends AbstractController
{

    public function __construct(
       private RandomColorGenerator $color
    ) {
    }

    public function index(): Response
    {
        return $this->render('test/testing.html.twig');
    }

    public function generateRandomColor(): Response
    {
        $color =  $this->color->getRandomColor();
        return $this->render('test/generate_random_color.html.twig', [
            'color' => $color
        ]);
    }

    public function sendNotification(EmailNotifier $emailNotifier): Response
    {
        $recipientEmail = 'user@example.com';

        // Prepare the notification details
        $subject = 'Important Notification';
        $message = 'This is an important notification for you.';

        // Send the notification
        $emailNotifier->sendNotification($recipientEmail, $subject, $message);
        $this->addFlash('success', 'Notification has been sent. Please check your email address');

        return $this->redirectToRoute('testing');

    }

    public function renderController(): Response
    {
        $color =  $this->color->getRandomColor();
        return $this->render('test/render_controller.html.twig', [
            'color' => $color
        ]);
    }


    public function doctrineQueries(CategoryRepository $categoryRepository) : Response
    {
        //$data = $categoryRepository->find(1);
        //$data = $categoryRepository->findOneBy(['id' => ['lt' => 10]]); //lt, gt lte gte
//        $data = $categoryRepository->findBy(['id' => [1,2,3]]);

//
//        $queryBuilder = $categoryRepository->createQueryBuilder('c');
//        $query = $queryBuilder
//            ->select('c.id', 'c.name')
//            ->where('c.name = :value')
//            ->setParameter('value', 'Automotive')
//            ->getQuery();
//        $data = $query->getResult();
//


        // Join query category with listings
        $data = $categoryRepository->getListings(1);

        return $this->render('test/doctrine_queries.html.twig', [
            'data' => $data
        ]);
    }



}
