<?php

namespace App\Application\User\UserLogin;


class ValidateTokenRequest implements ValidateTokenRequestInterface
{
    public $token;


    public function __construct(String $token)
    {
        $this->token = $token;
    }
}
