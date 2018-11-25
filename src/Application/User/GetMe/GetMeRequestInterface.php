<?php

namespace App\Application\User\GetMe;


interface GetMeRequestInterface
{
    public function __construct(String $user_id);
}
