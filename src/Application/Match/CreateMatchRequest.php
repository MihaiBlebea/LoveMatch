<?php

namespace App\Application\Match;


class CreateMatchRequest implements CreateMatchRequestInterface
{
    public $first_user_id;

    public $second_user_id;


    public function __construct(
        String $first_user_id,
        String $second_user_id)
    {
        $this->first_user_id  = $first_user_id;
        $this->second_user_id = $second_user_id;
    }
}
