<?php

namespace App\Application\User\GetUsers;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\CalculateYearFromAgeService;



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

        // Get the distance that the users should be related to the current user
        $distance = $user->getDistance()->getDistance();

        // Create an array of user's ids that must be excluded because they already been liked or passed
        $exclude_ids = $user->getActionsUserIds();

        // Calculate birth year from age
        $min_year = (string) CalculateYearFromAgeService::execute($user->getAgeInterval()->getMin());
        $max_year = (string) CalculateYearFromAgeService::execute($user->getAgeInterval()->getMax());


        return $this->user_repo->all(
            $request->count,
            $user->getGender()->getOpposite(),
            (string) $user->getId(),
            $user->getLocation()->getMinLongitude($distance),
            $user->getLocation()->getMaxLongitude($distance),
            $user->getLocation()->getMinLatitude($distance),
            $user->getLocation()->getMaxLatitude($distance),
            $distance,
            $min_year,
            $max_year,
            $exclude_ids
        );
    }
}
