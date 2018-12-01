<?php

namespace App\Infrastructure\Persistence\Match;

use Ramsey\Uuid\Uuid;
use App\Domain\User\UserId\UserId;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\UserRepoInterface;
use App\Domain\Match\Match;
use App\Domain\Match\MatchInterface;
use App\Domain\Match\MatchFactory;
use App\Domain\Match\MatchId\MatchId;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\MatchRepoInterface;
use App\Domain\Match\Message\MessageRepoInterface;
use App\Infrastructure\Persistence\Message\DominoMessageRepo;
use App\Infrastructure\Persistence\User\DominoUserRepo;


class DominoMatchRepo implements MatchRepoInterface
{
    private $persist;

    private $matches = [];


    public function __construct($persist = null)
    {
        $this->persist = $persist;
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
            $this->persist->table('matches')->where('id', (string) $match->getId())->update([
                'first_user_id'  => (string) $match->getUsers()[0]->getId(),
                'second_user_id' => (string) $match->getUsers()[1]->getId(),
            ]);
        } else {
            $this->persist->table('matches')->create([
                'id'             => (string) $match->getId(),
                'first_user_id'  => (string) $match->getUsers()[0]->getId(),
                'second_user_id' => (string) $match->getUsers()[1]->getId(),
                'created_on'     => $match->getCreatedOn()
            ]);
        }

        if($match->getMessageCount() > 0)
        {
            foreach($match->getMessages() as $message)
            {
                $message_repo = new DominoMessageRepo($this->persist);
                $message_repo->add($message);
            }
        }
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
            return $this->buildMatch($match);
        }
        return null;
    }

    public function withUserId(UserIdInterface $id)
    {
        $matches = $this->persist->table('matches')
                                 ->where('first_user_id', (string) $id->getId())
                                 ->orWhere('second_user_id', (string) $id->getId())
                                 ->select();

        if($matches && count($matches) > 0)
        {
            $user_repo = new DominoUserRepo($this->persist);
            $message_repo = new DominoMessageRepo($this->persist);
            foreach($matches as $row)
            {
                $this->matches[] = $this->buildMatch($row, $user_repo, $message_repo);;
            }
            return $this->matches;
        }
        return null;
    }

    private function buildMatch(
        Array $row,
        UserRepoInterface $user_repo,
        MessageRepoInterface $message_repo)
    {
        $match = MatchFactory::build(
            $row['id'],
            $user_repo->withId(new UserId($row['first_user_id'])),
            $user_repo->withId(new UserId($row['second_user_id'])),
            $row['created_on']
        );

        $messages = $message_repo->withMatchId(new MatchId($row['id']));
        if($messages && count($messages) > 0)
        {
            $match->addMessages($messages);
        }
        return $match;
    }
}
