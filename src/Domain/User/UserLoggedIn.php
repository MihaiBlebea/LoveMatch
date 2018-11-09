<?php

namespace App\Domain\User;

use App\Domain\User\{
    Email\EmailInterface,
    Name\NameInterface
};


class UserLoggedIn
{
    private $email;

    private $name;

    private $occured_on;


    public function __construct(Emailinterface $email, NameInterface $name)
    {
        $this->email      = $email;
        $this->name       = $name;
        $this->occured_on = new \DateTime();
    }

    public function ocurredOn()
    {
        return $this->ocurred_on;
    }
}
