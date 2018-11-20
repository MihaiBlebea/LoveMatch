<?php

namespace App\Domain\User\Token;


interface TokenInterface
{
    public function __construct(String $token);

    public function getToken();
}
