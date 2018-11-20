<?php

namespace App\Domain\User\Token;


interface TokenInterface
{
    public function __construct(String $token);

    public function isEqual(TokenInterface $token);

    public function getToken();

    public function __toString();
}
