<?php

namespace App\Application\Match;

use App\Domain\Match\MatchRepoInterface;
use App\Domain\Match\MatchFactory;
use App\Domain\User\UserId\UserId;
use App\Domain\User\UserRepoInterface;
use App\Application\Match\CreateMatchRequestInterface;


class CreateMatchService
{
    private $match_repo;

    private $user_repo;


    public function __construct(
        MatchRepoInterface $match_repo,
        UserRepoInterface $user_repo)
    {
        $this->match_repo = $match_repo;
        $this->user_repo  = $user_repo;
    }

    public function execute(CreateMatchRequestInterface $request)
    {
        $first_user  = $this->user_repo->withId(new UserId($request->first_user_id));
        $second_user = $this->user_repo->withId(new UserId($request->second_user_id));

        $match = MatchFactory::build(
            (string) $this->match_repo->nextId(),
            $first_user,
            $second_user
        );

        $this->match_repo->add($match);
        return $match;
    }
}
