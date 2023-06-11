<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserRegisteredEvent extends Event
{
    public function __construct(private array $userData)
    {

    }

    public function getUserData(): array
    {
        return $this->userData;
    }
}