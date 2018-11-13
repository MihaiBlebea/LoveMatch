<?php

namespace App\Infrastructure\Match;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Match\Match;
use App\Domain\Match\MatchId\MatchId;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\MatchRepoInterface;
use App\Infrastructure\Like\LikeRepo;
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
            'id'         => (string) $match->getId(),
            'user_a'     => $match->getUsers()[0],
            'user_b'     => $match->getUsers()[1],
            'created_on' => $match->getCreatedOn()
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
        $this->persist->table('matches')->where('id', (string) $match->getId())->delete();
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
        $match = $this->persist->table('matches')->where('id', (string) $id->getId())->selectOne();
        if($match)
        {
            $like_repo = new LikeRepo($this->persist);
            $like_a = $like_repo->withUserIds(
                new UserId($match['user_a']),
                new UserId($match['user_b'])
            );
            $like_b = $like_repo->withUserIds(
                new UserId($match['user_b']),
                new UserId($match['user_a'])
            );

            if($like_b !== null && $like_b !== null)
            {
                return new Match(
                    new MatchId($match['id']),
                    $like_a,
                    $like_b,
                    $match['created_on']
                );
            }
        }
    }
}
