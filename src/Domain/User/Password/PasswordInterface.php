<?php

namespace App\Domain\User\Password;


interface PasswordInterface
{
    public function __construct(String $password);

    public function getPassword();

    public function __toString();

    public function getHashedPassword();

    public function verifyPassword(String $password);
}
