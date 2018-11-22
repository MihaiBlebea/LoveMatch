<?php

namespace App\Application\User\UserRegister;


class UserRegisterRequest implements UserRegisterRequestInterface
{
    public $name;

    public $birth_date;

    public $gender;

    public $email;

    public $longitude;

    public $latitude;

    public $password;


    public function __construct(
        String $name,
        String $birth_date,
        String $gender,
        String $email,
        String $longitude,
        String $latitude,
        String $password)
    {
        $this->name       = $name;
        $this->birth_date = $birth_date;
        $this->gender     = $gender;
        $this->email      = $email;
        $this->longitude  = $longitude;
        $this->latitude   = $latitude;
        $this->password   = $password;
    }
}
