<?php

namespace App\Application\Match\GetMatches;


interface GetMatchesRequestInterface
{
    public function __construct(String $user_id);
}
