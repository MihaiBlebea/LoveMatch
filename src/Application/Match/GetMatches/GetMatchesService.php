<?php

namespace App\Application\Match\GetMatches;

use App\Domain\Match\MatchRepoInterface;
use App\Domain\User\UserId\UserId;


class GetMatchesService
{
    public function __construct(MatchRepoInterface $match_repo)
    {
        $this->match_repo = $match_repo;
    }

    public function execute(GetMatchesRequestInterface $request)
    {
        return $this->match_repo->withUserId(new UserId($request->user_id));
    }
}
