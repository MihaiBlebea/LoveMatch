<?php

namespace App\Application\User\UserLogin;

use App\Infrastructure\Authorization\JWTAuthorize;
use App\Domain\User\UserRepoInterface;
use App\Domain\User\Token\Token;


class ValidateUserTokenService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(String $string_token)
    {
        $token = new Token($string_token);
        $decoded    = JWTAuthorize::decode($token);
        $is_expired = JWTAuthorize::hasExpired((array) $decoded);
        if($is_expired === false)
        {
            return $this->user_repo->withToken($token);
        }
        return null;
    }
}
