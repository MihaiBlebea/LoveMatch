<?php

namespace App\Infrastructure\Authorization;

use Firebase\JWT\JWT;
use Carbon\Carbon;


class JWTAuthorize implements JWTAuthorizeInterface
{
    private static $key = 'example_key';


    public static function encode(
        String $email,
        String $password,
        String $id)
    {
        $token = array(
            'created_on' => Carbon::now(),
            'expires'    => 2,
            'email'      => $email,
            'password'   => $password,
            'user_id'    => $id
        );
        return JWT::encode($token, self::$key);
    }

    public static function decode(String $token)
    {
        return JWT::decode($token, self::$key, array('HS256'));
    }

    public static function hasExpired(Array $token)
    {
        $expires = new Carbon($token['created_on']);
        $expires->addMinutes($token['expires']);
        $now = Carbon::now();
        return $now->greaterThan($expires);
    }
}
