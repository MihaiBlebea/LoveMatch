<?php

namespace App\Application\User\GetMe;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;


class GetMeService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(GetMeRequestInterface $request)
    {
        $user = $this->user_repo->withId(new UserId($request->user_id));
        return $user;
    }
}
