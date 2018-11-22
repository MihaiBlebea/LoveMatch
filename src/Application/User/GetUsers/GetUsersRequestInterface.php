<?php

namespace App\Application\User\GetUsers;


interface GetUsersRequestInterface
{
    public function __construct(
        String $count,
        String $gender,
        String $long,
        String $lat,
        Int $distance,
        String $user_id,
        Int $min_age,
        Int $max_age);
}
