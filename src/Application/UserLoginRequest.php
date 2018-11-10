<?php

namespace App\Application;

use App\Domain\User\{
    Email\Email,
    Password\Password
};


class UserLoginRequest
{
    private $email;

    private $password;


    public function __construct(String $email, String $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    public function getEmail()
    {
        return new Email($this->email);
    }

    public function getPassword()
    {
        return new Password($this->password);
    }
}
