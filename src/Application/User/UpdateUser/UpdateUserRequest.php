<?php

namespace App\Application\User\UpdateUser;


class UpdateUserRequest implements UpdateUserRequestInterface
{
    public $user_id;

    public $name;

    public $birth_date;

    public $gender;

    public $email;

    public $longitude;

    public $latitude;

    public $password;


    public function __construct(
        String $user_id,
        String $name,
        String $birth_date,
        String $gender,
        String $email,
        String $longitude,
        String $latitude,
        String $password = null)
    {
        $this->user_id    = $user_id;
        $this->name       = $name;
        $this->birth_date = $birth_date;
        $this->gender     = $gender;
        $this->email      = $email;
        $this->longitude  = $longitude;
        $this->latitude   = $latitude;
        $this->password   = $password;
    }
}
