<?php

namespace App\Domain\User\Email;


class Email implements EmailInterface
{
    private $email;


    public function __construct(String $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function isEqual(EmailInterface $email)
    {
        return $this->getEmail() === $email->getEmail();
    }

    public function __toString()
    {
        return $this->getEmail();
    }
}
