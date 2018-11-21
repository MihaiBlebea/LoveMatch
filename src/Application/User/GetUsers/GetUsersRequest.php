<?php

namespace App\Application\User\GetUsers;


class GetUsersRequest implements GetUsersRequestInterface
{
    public $count;

    public $gender;


    public function __construct(String $count, String $gender)
    {
        $this->count  = $count;
        $this->gender = $gender;
    }
}
