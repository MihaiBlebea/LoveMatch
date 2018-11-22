<?php

namespace App\Application\User\GetUsers;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\Gender\Gender;
use App\Domain\User\UserId\UserId;
use App\Domain\User\Location\Location;


class GetUsersService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(GetUsersRequestInterface $request)
    {
        return $this->user_repo->all(
            $request->count,
            new Gender($request->gender),
            new UserId($request->user_id),
            new Location($request->long, $request->lat),
            $request->distance,
            $request->min_age,
            $request->max_age);
    }
}
