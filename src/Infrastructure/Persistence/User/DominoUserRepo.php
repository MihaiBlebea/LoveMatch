<?php

namespace App\Infrastructure\Persistence\User;

use Ramsey\Uuid\Uuid;
use App\Domain\User\User;
use App\Domain\User\UserInterface;
use App\Domain\User\UserFactory;
use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Email\EmailInterface;
use App\Domain\User\Token\TokenInterface;
use App\Domain\User\Token\Token;
use App\Infrastructure\Persistence\Action\DominoActionRepo;


class DominoUserRepo implements UserRepoInterface
{
    private $users = [];

    private $persist;


    public function __construct($persist = null)
    {
        $this->persist = $persist;
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
            $this->persist->table('users')->where('id', (string) $saved_user->getId())->update([
                'name'       => (string) $user->getName(),
                'birth_date' => (string) $user->getBirthDate(),
                'gender'     => (string) $user->getGender(),
                'email'      => (string) $user->getEmail(),
                'password'   => (string) $user->getPassword(),
                'token'      => $user->getToken() ? (string) $user->getToken() : null,
            ]);
        } else {
            $this->persist->table('users')->create([
                'id'         => (string) $user->getId(),
                'name'       => (string) $user->getName(),
                'birth_date' => (string) $user->getBirthDate(),
                'gender'     => (string) $user->getGender(),
                'email'      => (string) $user->getEmail(),
                'password'   => (string) $user->getPassword()->getHashedPassword(),
                'token'      => $user->getToken() ? (string) $user->getToken() : null,
                'created_on' => (string) $user->getCreatedOn()
            ]);
        }

        // Save the actions in the action array
        if(count($user->getActions()) > 0)
        {
            $action_repo = new DominoActionRepo($this->persist);
            $action_repo->addAll($user->getActions());
        }
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
        $this->persist->table('users')->where('id', (string) $user->getId())->delete();
    }

    public function removeAll(Array $users)
    {
        foreach($users as $user)
        {
            $this->remove($user);
        }
    }

    private function buildUserAndDependencies(Array $row)
    {
        $user = UserFactory::build(
            $row['id'],
            $row['name'],
            $row['birth_date'],
            $row['gender'],
            $row['email'],
            $row['password'],
            $row['created_on']
        );

        // Get Auth token
        if($row['token'])
        {
            $user->addToken(new Token($row['token']));
        }

        // get action repo
        $action_repo = new DominoActionRepo($this->persist);
        $actions = $action_repo->withSenderId($user->getId());

        if($actions && count($actions) > 0)
        {
            $user->addActions($actions);
        }
        return $user;
    }

    public function withId(UserIdInterface $id)
    {
        $user = $this->persist->table('users')
                              ->where('id', (string) $id->getId())
                              ->selectOne();
        if($user)
        {
            return $this->buildUserAndDependencies($user);
        }
        return null;
    }

    public function withEmail(EmailInterface $email)
    {
        $user = $this->persist->table('users')
                              ->where('email', (string) $email->getEmail())
                              ->selectOne();
        if($user)
        {
            return $this->buildUserAndDependencies($user);
        }
        return null;
    }

    public function withToken(TokenInterface $token)
    {
        $user = $this->persist->table('users')
                              ->where('token', $token->getToken())
                              ->selectOne();
        if($user)
        {
            return $this->buildUserAndDependencies($user);
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
                $this->users[] = $this->buildUserAndDependencies($user);
            }
            return $this->users;
        }
        return null;
    }
}
