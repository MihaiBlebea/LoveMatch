<?php

namespace App\Application\User\GetUsers;


class GetUsersRequest implements GetUsersRequestInterface
{
    public $count;

    public $user_id;


    public function __construct(String $count, String $user_id)
    {
        $this->count    = $count;
        $this->user_id  = $user_id;
    }
}
