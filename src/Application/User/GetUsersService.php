<?php

namespace App\Application\User;

use App\Domain\User\UserRepoInterface;


class GetUsersService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute()
    {
        return $this->user_repo->all();
    }
}