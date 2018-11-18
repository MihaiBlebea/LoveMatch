<?php

namespace App\Application\User;


interface UserRegisterRequestInterface
{
    public function __construct(
        String $name,
        String $birth_date,
        String $gender,
        String $email,
        String $password);
}
