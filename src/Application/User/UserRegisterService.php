<?php

namespace App\Application\User;

use App\Domain\User\UserRepoInterface;
use App\Domain\RequestInterface;
use App\Domain\DomainEventPublisher;
use App\Domain\User\UserRegistered;
use App\Domain\User\UserFactory;


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
        $this->user_repo->add($user);

        $publisher = DomainEventPublisher::instance();
        $publisher->publish(new UserRegistered($user->getId()));

        return $user;
    }
}
