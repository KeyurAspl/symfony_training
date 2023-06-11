<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class EmailNotifier
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotification(string $recipientEmail, string $subject, string $message): void
    {
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($recipientEmail)
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }
}