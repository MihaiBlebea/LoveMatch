<?php

namespace App\Application\User\UserLogin;


interface ValidateTokenRequestInterface
{
    public function __construct(String $token);
}
