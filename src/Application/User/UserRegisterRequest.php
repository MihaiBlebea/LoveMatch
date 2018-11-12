<?php

namespace App\Application\User;


class UserRegisterRequest implements UserRegisterRequestInterface
{
    private $name;

    private $birth_date;

    private $email;

    private $password;


    public function __construct(
        String $name,
        String $birth_date,
        String $email,
        String $password)
    {
        $this->name       = $name;
        $this->birth_date = $birth_date;
        $this->email      = $email;
        $this->password   = $password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
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
