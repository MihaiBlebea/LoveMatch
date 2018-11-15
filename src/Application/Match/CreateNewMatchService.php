<?php

namespace App\Application\Match;

use App\Domain\Match\MatchRepoInterface;
use App\Domain\Match\MatchFactory;
use App\Domain\Action\ActionRepoInterface;
use App\Domain\Action\ActionId\ActionId;
use App\Application\Match\NewMatchRequestInterface;


class CreateNewMatchService
{
    private $match_repo;

    private $like_repo;


    public function __construct(
        MatchRepoInterface $match_repo,
        ActionRepoInterface $action_repo)
    {
        $this->match_repo  = $match_repo;
        $this->action_repo = $action_repo;
    }

    public function execute(NewMatchRequestInterface $request)
    {
        $like_a = $this->action_repo->withId(new ActionId($request->getFirstLikeId()));
        $like_b = $this->action_repo->withId(new ActionId($request->getSecondLikeId()));

        $match = MatchFactory::build(
            (string) $this->match_repo->nextId(),
            $like_a,
            $like_b
        );

        $this->match_repo->add($match);
        dd($this->match_repo->withId($match->getId()));
        return $match;
    }
}
