<?php

namespace App\Domain\User;

use App\Domain\User\UserId\UserIdInterface;


class UserLoggedIn implements DomainEventInterface
{
    private $user_id;

    private $ocurred_on;


    public function __construct(UserIdInterface $user_id)
    {
        $this->user_id    = $user_id;
        $this->ocurred_on = new \DateTime();
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getBody()
    {
        return 'User is logged in the app';
    }

    public function ocurredOn()
    {
        return $this->ocurred_on;
    }
}
