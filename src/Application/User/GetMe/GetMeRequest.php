<?php

namespace App\Application\User\GetMe;


class GetMeRequest implements GetMeRequestInterface
{
    public $user_id;


    public function __construct(String $user_id)
    {
        $this->user_id  = $user_id;
    }
}
