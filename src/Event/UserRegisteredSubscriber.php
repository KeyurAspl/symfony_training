<?php

namespace App\Event;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserRegisteredSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer, private string $fromEmail)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisteredEvent::class => 'sendNotificationEmail',
        ];
    }


    public function sendNotificationEmail(UserRegisteredEvent $event)
    {
        $userData = $event->getUserData();
        $email = (new Email())
            ->from($this->fromEmail)
            ->to($userData['email'])
            ->subject('Welcome to classified ads.')
            ->text('Hello '.$userData['name'].'Your account is successfully created. This email is created from subscriber event');

        $this->mailer->send($email);
    }


}