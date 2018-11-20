<?php

namespace App\Application\User\UserLogin;

use App\Infrastructure\Authorization\JWTAuthorize;
use App\Domain\DomainEventPublisher;
use App\Domain\User\UserRepoInterface;
use App\Domain\User\Email\Email;
use App\Domain\User\Password\Password;
use App\Domain\User\Token\Token;
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
            $token = JWTAuthorize::encode((string) $user->getEmail(), (string) $user->getPassword());
    
            $user->addToken(new Token($token));

            $this->user_repo->add($user);

            // Publish and event
            $publisher = DomainEventPublisher::instance();
            $publisher->publish(new UserLoggedIn($user->getId()));

            return $user;
        }
        return null;
    }
}
