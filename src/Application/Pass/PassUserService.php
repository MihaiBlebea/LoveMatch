<?php

namespace App\Application\Pass;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\Pass\Pass;
use App\Domain\Pass\PassRepoInterface;


class PassUserService
{
    private $pass_repo;

    private $user_repo;


    public function __construct(
        UserRepoInterface $user_repo,
        PassRepoInterface $pass_repo)
    {
        $this->user_repo = $user_repo;
        $this->pass_repo = $pass_repo;
    }

    public function execute(PassUserRequestInterface $request)
    {
        $pass = new Pass(
            $this->pass_repo->nextId(),
            $this->user_repo->withId(new UserId($request->getOwnerId())),
            $this->user_repo->withId(new UserId($request->getReceiverId()))
        );
        $this->pass_repo->add($pass);
    }
}
