<?php

namespace App\Application\User;


class UserLoginRequest implements UserLoginRequestInterface
{
    public $email;

    public $password;


    public function __construct(String $email, String $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }
}
