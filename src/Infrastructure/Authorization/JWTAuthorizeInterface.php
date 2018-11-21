<?php

namespace App\Infrastructure\Authorization;


interface JWTAuthorizeInterface
{
    public static function encode(
        String $email,
        String $password,
        String $id);

    public static function decode(String $token);
}
