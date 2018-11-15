<?php

namespace App\Infrastructure\Match;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Match\Match;
use App\Domain\Match\MatchId\MatchId;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\MatchRepoInterface;
use App\Domain\Action\ActionId\ActionId;
use App\Infrastructure\Action\ActionRepo;
use App\Domain\User\UserId\UserId;


class MatchRepo implements MatchRepoInterface
{
    private $persist;

    private $matches = [];


    public function __construct(PersistenceInterface $persist)
    {
        $this->persist = $persist;
    }

    public function nextId()
    {
        return new MatchId(strtoupper(Uuid::uuid4()));
    }

    public function add(Match $match)
    {
        $this->persist->table('matches')->create([
            'id'          => (string) $match->getId(),
            'action_a_id' => $match->getUsers()[0],
            'action_b_id' => $match->getUsers()[1],
            'created_on'  => $match->getCreatedOn()
        ]);
    }

    public function addAll(Array $matches)
    {
        foreach($matches as $match)
        {
            $this->add($match);
        }
    }

    public function remove(Match $match)
    {
        $this->persist->table('matches')
                      ->where('id', (string) $match->getId())
                      ->delete();
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
        $match = $this->persist->table('matches')
                               ->where('id', (string) $id->getId())
                               ->selectOne();
        if($match)
        {
            $action_repo = new ActionRepo($this->persist);
            $action_a = $action_repo->withId(new ActionId($match['action_a_id']));
            $action_b = $action_repo->withId(new ActionId($match['action_b_id']));
            dd($$action_a);
            if($action_a && $action_b)
            {
                return new Match(
                    new MatchId($match['id']),
                    $action_a,
                    $action_b,
                    $match['created_on']);
            }
            return null;
        }
        return null;
    }
}
