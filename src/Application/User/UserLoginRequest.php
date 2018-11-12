<?php

namespace App\Application\User;


class UserLoginRequest implements UserLoginRequestInterface
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
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
