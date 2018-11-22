<?php

namespace App\Application\User\GetUsers;


class GetUsersRequest implements GetUsersRequestInterface
{
    public $count;

    public $gender;

    public $long;

    public $lat;

    public $distance;

    public $auth_user_id;


    public function __construct(
        String $count,
        String $gender,
        String $long,
        String $lat,
        Int $distance,
        String $user_id)
    {
        $this->count    = $count;
        $this->gender   = $gender;
        $this->long     = $long;
        $this->lat      = $lat;
        $this->distance = $distance;
        $this->user_id  = $user_id;
    }
}
