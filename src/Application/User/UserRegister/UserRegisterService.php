<?php

namespace App\Application\User\UserRegister;

use App\Infrastructure\Authorization\JWTAuthorize;
use App\Domain\User\UserRepoInterface;
use App\Domain\RequestInterface;
use App\Domain\DomainEventPublisher;
use App\Domain\User\UserRegistered;
use App\Domain\User\UserFactory;
use App\Domain\User\Token\Token;


class UserRegisterService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UserRegisterRequestInterface $request)
    {
        $user = UserFactory::build(
            $this->user_repo->nextId(),
            $request->name,
            $request->birth_date,
            $request->gender,
            $request->email,
            $request->password
        );

        $token = JWTAuthorize::encode(
            (string) $user->getEmail(),
            (string) $user->getPassword(),
            (string) $user->getId()
        );
        $user->addToken(new Token($token));

        $this->user_repo->add($user);

        $publisher = DomainEventPublisher::instance();
        $publisher->publish(new UserRegistered($user->getId()));

        return $user;
    }
}
