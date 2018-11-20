<?php

namespace App\Infrastructure\Persistence\User;

use Ramsey\Uuid\Uuid;
use App\Domain\User\UserInterface;
use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Email\EmailInterface;
use App\Domain\User\Token\TokenInterface;
use App\Domain\User\Password\Password;


class InMemoryUserRepo implements UserRepoInterface
{
    private $users = [];

    public function __construct($persist = null)
    {
        //
    }

    public function nextId()
    {
        return new UserId(strtoupper(Uuid::uuid4()));
    }

    public function add(UserInterface $user)
    {
        $saved_user = $this->withId($user->getId());

        if($saved_user)
        {
            $this->remove($saved_user);
        }
        $user->setPassword(new Password($user->getPassword()->getHashedPassword()));
        $this->users[] = $user;
    }

    public function addAll(Array $users)
    {
        foreach($users as $user)
        {
            $this->add($user);
        }
    }

    public function remove(UserInterface $user)
    {
        foreach($this->users as $saved_user)
        {
            if($saved_user->getId()->isEqual($user->getId()))
            {
                unset($saved_user);
            }
        }
        array_values($this->users);
    }

    public function removeAll(Array $users)
    {
        foreach($users as $user)
        {
            $this->remove($user);
        }
    }

    public function withId(UserIdInterface $id)
    {
        foreach($this->users as $user)
        {
            if($user->getId()->isEqual($id))
            {
                return $user;
            }
        }
        return null;
    }

    public function withEmail(EmailInterface $email)
    {
        foreach($this->users as $user)
        {
            if($user->getEmail()->isEqual($email))
            {
                return $user;
            }
        }
        return null;
    }

    public function withToken(TokenInterface $token)
    {
        foreach($this->users as $user)
        {
            if($user->getToken()->isEqual($token))
            {
                return $user;
            }
        }
        return null;
    }

    public function all(Int $count = null)
    {
        return $this->users;
    }
}
