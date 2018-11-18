<?php

namespace App\Application\User;


interface UserLoginRequestInterface
{
    public function __construct(
        String $email,
        String $password);
}
