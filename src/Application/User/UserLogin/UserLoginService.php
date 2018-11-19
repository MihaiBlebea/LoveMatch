<?php

namespace App\Application\User\UserLogin;

use App\Domain\DomainEventPublisher;
use App\Domain\User\UserRepoInterface;
use App\Domain\User\Email\Email;
use App\Domain\User\Password\Password;
use App\Domain\User\UserLoggedIn;


class UserLoginService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UserLoginRequestInterface $request)
    {
        $user = $this->user_repo->withEmail(new Email($request->email));
        if($user && $user->getPassword()->verifyPassword(new Password($request->password)))
        {
            // Publish and event
            $publisher = DomainEventPublisher::instance();
            $publisher->publish(new UserLoggedIn($user->getId()));

            return $user;
        }
        return null;
    }
}
