<?php

namespace App\Application\User\GetUsers;


interface GetUsersRequestInterface
{
    public function __construct(String $count, String $user_id);
}
