<?php

namespace App\Application\User;


interface UserRegisterRequestInterface
{
    public function __construct(
        String $name,
        String $birth_date,
        String $email,
        String $password);

    public function getName();

    public function getBirthDate();

    public function getEmail();

    public function getPassword();
}
