<?php

namespace App\Domain\User;

use JsonSerializable;
use App\Domain\User\{
    UserId\UserIdInterface,
    Name\NameInterface,
    BirthDate\BirthDateInterface,
    Email\EmailInterface,
    Password\PasswordInterface
};


class User implements JsonSerializable
{
    private $id;

    private $name;

    private $birth_date;

    private $email;

    private $password;


    public function __construct(
        UserIdInterface $id,
        NameInterface $name,
        BirthDateInterface $birth_date,
        EmailInterface $email,
        PasswordInterface $password)
    {
        $this->id         = $id;
        $this->name       = $name;
        $this->birth_date = $birth_date;
        $this->email      = $email;
        $this->password   = $password;
    }

    public function getId()
    {
        return $this->id;
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

    public function jsonSerialize()
    {
        return [
            'id'         => (string) $this->getId(),
            'name'       => (string) $this->getName(),
            'birth_date' => $this->getBirthDate(),
            'email'      => (string) $this->getEmail(),
            'password'   => (string) $this->getPassword()
        ];
    }
}
