<?php

namespace App\Application\User\GetUsers;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;


class GetUsersService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(GetUsersRequestInterface $request)
    {
        $user = $this->user_repo->withId(new UserId($request->user_id));

        if(!$user)
        {
            throw new \Exception('Could not find user with id ' . $request->user_id, 1);
        }

        $distance = $user->getDistance()->getDistance();

        return $this->user_repo->all(
            $request->count,
            $user->getGender()->getOpposite(),
            (string) $user->getId(),
            $user->getLocation()->getMinLongitude($distance),
            $user->getLocation()->getMaxLongitude($distance),
            $user->getLocation()->getMinLatitude($distance),
            $user->getLocation()->getMaxLatitude($distance),
            $distance,
            $user->getAgeInterval()->getMin(),
            $user->getAgeInterval()->getMax());
    }
}
