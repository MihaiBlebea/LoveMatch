<?php

namespace App\Application\Match\GetMatches;


class GetMatchesRequest implements GetMatchesRequestInterface
{
    public $user_id;


    public function __construct(String $user_id)
    {
        $this->user_id = $user_id;
    }
}
