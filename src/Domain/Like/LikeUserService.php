<?php

namespace App\Domain\Like;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Application\Like\LikeUserRequestInterface;


class LikeUserService
{
    private $like_repo;

    private $user_repo;


    public function __construct(
        UserRepoInterface $user_repo,
        LikeRepoInterface $like_repo)
    {
        $this->user_repo = $user_repo;
        $this->like_repo = $like_repo;
    }

    public function execute(LikeUserRequestInterface $request)
    {
        $like = new Like(
            $this->like_repo->nextId(),
            $this->user_repo->withId(new UserId($request->getOwnerId())),
            $this->user_repo->withId(new UserId($request->getReceiverId()))
        );
        $this->like_repo->add($like);
    }
}
