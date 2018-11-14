<?php

namespace App\Application\Match;

use App\Domain\Match\MatchRepoInterface;
use App\Domain\Match\Match;
use App\Domain\Like\LikeRepoInterface;
use App\Domain\Like\LikeId\LikeId;
use App\Application\Match\NewMatchRequestInterface;


class CreateNewMatchService
{
    private $match_repo;

    private $like_repo;


    public function __construct(
        MatchRepoInterface $match_repo,
        LikeRepoInterface $like_repo)
    {
        $this->match_repo = $match_repo;
        $this->like_repo  = $like_repo;
    }

    public function execute(NewMatchRequestInterface $request)
    {
        $like_a = $this->like_repo->withId(new LikeId($request->getFirstLikeId()));
        $like_b = $this->like_repo->withId(new LikeId($request->getSecondLikeId()));

        $match = new Match(
            $this->match_repo->nextId(),
            $like_a,
            $like_b);

        $this->match_repo->add($match);
        return $match;
    }
}
