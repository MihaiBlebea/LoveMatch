<?php

namespace App\Domain\User\Password;


class Password implements PasswordInterface
{
    private $password;


    public function __construct(String $password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function __toString()
    {
        return $this->getPassword();
    }

    public function getHashedPassword()
    {
        return $this->hashPassword($this->password);
    }

    public function verifyPassword(String $password)
    {
        return password_verify($password, $this->password);
    }

    private function hashPassword(String $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
