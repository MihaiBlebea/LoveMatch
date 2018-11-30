<?php

namespace App\Application\User\UpdateUser;


interface UpdateUserRequestInterface
{
    public function __construct(
        String $user_id,
        String $name,
        String $birth_date,
        String $gender,
        String $email,
        String $longitude,
        String $latitude,
        String $password = null);
}
