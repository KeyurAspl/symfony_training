<?php

namespace App\Controller;

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



}
