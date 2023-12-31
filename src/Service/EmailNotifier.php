<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class EmailNotifier
{
    private $mailer;

    public function __construct(MailerInterface $mailer, private string $fromEmail)
    {
        $this->mailer = $mailer;
    }

    public function sendNotification(string $recipientEmail, string $subject, string $message): void
    {
        $email = (new Email())
            ->from($this->fromEmail)
            ->to($recipientEmail)
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }
}