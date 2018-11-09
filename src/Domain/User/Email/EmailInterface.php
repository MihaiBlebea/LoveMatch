<?php

namespace App\Domain\User\Email;


interface EmailInterface
{
    public function __construct(String $email);

    public function getEmail();

    public function __toString();
}
