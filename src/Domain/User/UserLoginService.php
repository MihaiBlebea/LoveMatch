<?php

namespace App\Domain\User;

use App\Application\User\UserLoginRequestInterface;
use App\Domain\DomainEventPublisher;
use App\Domain\User\Email\Email;
use App\Domain\User\Password\Password;


class UserLoginService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UserLoginRequestInterface $request)
    {
        if($_SESSION['auth'] !== null)
        {
            throw new \Exception('This user or another user is already logged in. Logout first', 1);
        }

        $user = $this->user_repo->withEmail(new Email($request->getEmail()));
        if($user && $user->getPassword()->verifyPassword(new Password($request->getPassword())))
        {
            // Publish and event
            $publisher = DomainEventPublisher::instance();
            $publisher->publish(new UserLoggedIn($user->getId()));

            $_SESSION['auth'] = $user->getId();
            return $user;
        }
        return null;
    }
}
