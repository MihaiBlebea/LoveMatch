<?php

namespace App\Application\User\UpdateUser;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\User;


class UpdateUserService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UpdateUserRequestInterface $request) : User
    {
        $user = $this->user_repo->withId(new UserId($request->user_id));

        if(!$user)
        {
            throw new \Exception('Could not find user with id ' . $request->user_id, 1);
        }

        $user->setName($request->name);
        $user->setBirthDate($request->birth_date);
        $user->setGender($request->gender);
        $user->setEmail($request->email);

        $this->user_repo->add($user);

        return $user;
    }
}
