<?php

namespace App\Event;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserRegisteredListener
{
    private $mailer;

    public function __construct(MailerInterface $mailer, private string $fromEmail)
    {
        $this->mailer = $mailer;
    }

    public function onUserRegistered(UserRegisteredEvent $event)
    {
        $userData = $event->getUserData();
        $email = (new Email())
            ->from($this->fromEmail)
            ->to($userData['email'])
            ->subject('Welcome to classified ads.')
            ->text('Hello '.$userData['name'].'Your account is successfully created.');

        $this->mailer->send($email);
    }
}