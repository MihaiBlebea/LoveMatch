<?php

namespace App\Application\User\AttachDescription;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\Description\Description;


class AttachDescriptionService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(AttachDescriptionRequestInterface $request)
    {
        $user = $this->user_repo->withId(new UserId($request->user_id));

        if($user)
        {
            $user->addDescription(new Description($request->description));
            $this->user_repo->add($user);
            return $user;
        }
        return null;
    }
}
