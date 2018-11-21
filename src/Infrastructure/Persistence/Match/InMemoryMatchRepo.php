<?php

namespace App\Infrastructure\Persistence\Match;

use Ramsey\Uuid\Uuid;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\Match\MatchInterface;
use App\Domain\Match\MatchId\MatchId;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\MatchRepoInterface;


class InMemoryMatchRepo implements MatchRepoInterface
{
    private $matches = [];


    public function __construct($persist = null)
    {
        //
    }

    public function nextId()
    {
        return new MatchId(strtoupper(Uuid::uuid4()));
    }

    public function add(MatchInterface $match)
    {
        $saved_match = $this->withId($match->getId());

        if($saved_match)
        {
            $this->remove($saved_match);
        }
        $this->matches[] = $match;
    }

    public function addAll(Array $matches)
    {
        foreach($matches as $match)
        {
            $this->add($match);
        }
    }

    public function remove(MatchInterface $match)
    {
        foreach($this->matches as $saved_match)
        {
            if($saved_match->getId()->isEqual($match->getId()))
            {
                unset($saved_match);
            }
        }
        array_values($this->matches);
    }

    public function removeAll(Array $matches)
    {
        foreach($matches as $match)
        {
            $this->remove($match);
        }
    }

    public function withId(MatchIdInterface $id)
    {
        foreach($this->matches as $match)
        {
            if($match->getId()->isEqual($id))
            {
                return $match;
            }
        }
        return null;
    }

    public function withUserId(UserIdInterface $id)
    {
        $result = [];
        foreach($this->matches as $match)
        {
            foreach($match->getUsers() as $user)
            {
                if($user->getId()->isEqual($id))
                {
                    $result[] = $match;
                }
            }
        }

        if(count($result) > 0)
        {
            return $result;
        }
        return null;
    }
}
