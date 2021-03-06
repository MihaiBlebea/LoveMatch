<?php

namespace App\Domain\User\Token;


class Token implements TokenInterface
{
    private $token;


    public function __construct(String $token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function isEqual(TokenInterface $token)
    {
        return $this->getToken() === $token->getToken();
    }

    public function __toString()
    {
        return $this->getToken();
    }
}
