<?php

namespace App\Infrastructure\Authorization;


interface JWTAuthorizeInterface
{
    public static function encode(String $email, String $password);

    public static function decode(String $token);
}
