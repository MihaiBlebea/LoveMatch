<?php

namespace App\Infrastructure\User;

use Ramsey\Uuid\Uuid;
use App\Domain\User\UserId\{
    UserId,
    UserIdInterface
};
use App\Domain\User\Email\EmailInterface;
use App\Domain\User\{
    User,
    UserFactory,
    UserRepoInterface
};


class UserRepo implements UserRepoInterface
{
    private $users = [];

    private $persist;


    public function __construct($persist)
    {
        $this->persist = $persist;
    }

    public function nextId()
    {
        return new UserId(strtoupper(Uuid::uuid4()));
    }

    public function add(User $user)
    {
        $this->persist->table('users')->create([
            'id'         => (string) $user->getId(),
            'name'       => (string) $user->getName(),
            'birth_date' => (string) $user->getBirthDate(),
            'email'      => (string) $user->getEmail(),
            'password'   => (string) $user->getPassword()->getHashedPassword()
        ]);
    }

    public function addAll(Array $users)
    {
        foreach($users as $user)
        {
            $this->add($user);
        }
    }

    public function remove(User $user)
    {
        $this->persist->table('users')->where('id', (string) $user->getId())->delete();
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
        $user = $this->persist->table('users')->where('id', (string) $id->getId())->selectOne();
        if($user)
        {
            return UserFactory::build(
                $user['id'],
                $user['name'],
                $user['birth_date'],
                $user['email'],
                $user['password']
            );
        }
        return null;
    }

    public function withEmail(EmailInterface $email)
    {
        $user = $this->persist->table('users')->where('email', (string) $email->getEmail())->selectOne();
        if($user)
        {
            return UserFactory::build(
                $user['id'],
                $user['name'],
                $user['birth_date'],
                $user['email'],
                $user['password']
            );
        }
        return null;
    }

    public function all(Int $count = null)
    {
        $query = $this->persist->table('users');
        if($count === null)
        {
            $users = $query->selectAll();
        } else {
            $users = $query->limit($count)->select();
        }

        if($users)
        {
            foreach($users as $user)
            {
                $this->users[] = UserFactory::build(
                    $user['id'],
                    $user['name'],
                    $user['birth_date'],
                    $user['email'],
                    $user['password']
                );
            }
            return $this->users;
        }
        return null;
    }
}
