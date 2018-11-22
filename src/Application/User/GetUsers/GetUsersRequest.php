<?php

namespace App\Application\User\GetUsers;


class GetUsersRequest implements GetUsersRequestInterface
{
    public $count;

    public $gender;

    public $long;

    public $lat;

    public $distance;

    public $user_id;

    public $min_age;

    public $max_age;


    public function __construct(
        String $count,
        String $gender,
        String $long,
        String $lat,
        Int $distance,
        String $user_id,
        Int $min_age,
        Int $max_age)
    {
        $this->count    = $count;
        $this->gender   = $gender;
        $this->long     = $long;
        $this->lat      = $lat;
        $this->distance = $distance;
        $this->user_id  = $user_id;
        $this->min_age  = $min_age;
        $this->max_age  = $max_age;
    }
}
