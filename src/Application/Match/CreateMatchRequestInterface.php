<?php

namespace App\Application\Match;


interface CreateMatchRequestInterface
{
    public function __construct(
        String $first_user_id,
        String $second_user_id);
}
