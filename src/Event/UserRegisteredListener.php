<?php

namespace App\Event;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
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

    /**
     * @param LifecycleEventArgs $args
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     *  prePersist, postPersist, preUpdate, postUpdate, preRemove, postRemove, preFlush, postLoad
     */

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // Check if the registered entity is a User
        if (!$entity instanceof User) {
            return;
        }

        // Send a welcome email to the registered user
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($entity->getEmail())
            ->subject('Welcome to our website')
            ->text('This email is fired from doctrine postPersist event after user registered.');

        $this->mailer->send($email);
    }
}