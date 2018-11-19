<?php

namespace App\Application\User\UserRegister;


class UserRegisterRequest implements UserRegisterRequestInterface
{
    public $name;

    public $birth_date;

    public $gender;

    public $email;

    public $password;


    public function __construct(
        String $name,
        String $birth_date,
        String $gender,
        String $email,
        String $password)
    {
        $this->name       = $name;
        $this->birth_date = $birth_date;
        $this->gender     = $gender;
        $this->email      = $email;
        $this->password   = $password;
    }
}
