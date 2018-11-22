<?php

namespace App\Application\User\UserRegister;


interface UserRegisterRequestInterface
{
    public function __construct(
        String $name,
        String $birth_date,
        String $gender,
        String $email,
        String $longitude,
        String $latitude,
        String $password);
}
