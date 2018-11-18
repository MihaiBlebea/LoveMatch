<?php

namespace App\Application\User\UserLogin;


interface UserLoginRequestInterface
{
    public function __construct(
        String $email,
        String $password);
}
