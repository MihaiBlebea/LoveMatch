<?php

namespace App\Domain\User;

use App\Domain\User\UserRepoInterface;
use App\Domain\RequestInterface;
use App\Domain\DomainEventPublisher;
use App\Application\User\UserRegisterRequestInterface;


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
            $request->getName(),
            $request->getBirthDate(),
            $request->getEmail(),
            $request->getPassword()
        );
        $this->user_repo->add($user);
        
        $publisher = DomainEventPublisher::instance();
        $publisher->publish(new UserRegistered($user->getId()));
    }
}
