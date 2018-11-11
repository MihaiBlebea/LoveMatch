<?php

namespace App\Infrastructure\Like;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Like\{
    LikeId\LikeId,
    LikeId\LikeIdInterface,
    Like,
    LikeRepoInterface
};
use App\Infrastructure\User\UserRepo;
use App\Domain\User\UserId\UserId;


class LikeRepo implements LikeRepoInterface
{
    private $persist;

    private $likes = [];


    public function __construct(PersistenceInterface $persist)
    {
        $this->persist = $persist;
    }

    public function nextId()
    {
        return new LikeId(strtoupper(Uuid::uuid4()));
    }

    public function add(Like $like)
    {
        $this->persist->table('Likees')->create([
            'id'         => $like->getId(),
            'owner'      => $like->getOwner()->getId(),
            'receiver'   => $like->getReceiver()->getId(),
            'created_on' => $like->getCreatedOn()
        ]);
    }

    public function addAll(Array $likes)
    {
        foreach($likes as $like)
        {
            $this->add($like);
        }
    }

    public function remove(Like $like)
    {
        $this->persist->table('Likees')->where('id', (string) $like->getId())->delete();
    }

    public function removeAll(Array $likes)
    {
        foreach($likes as $like)
        {
            $this->remove($like);
        }
    }

    public function withId(LikeIdInterface $id)
    {
        $like = $this->persist->table('Likees')->where('id', $id)->selectOne();
        if($like)
        {
            $user_repo = new UserRepo($this->persist);
            return new Like(
                new LikeId($like['id']),
                $user_repo->withId(new UserId($like['owner'])),
                $user_repo->withId(new UserId($like['receiver'])),
                $like['created_on']
            );
        }
        return null;
    }

    public function withOwnerId(LikeIdInterface $id)
    {
        $likes = $this->persist->table('Likees')->where('owner', (string) $id->getId())->select();

        if(count($likes) > 0)
        {
            $user_repo = new UserRepo($this->persist);
            foreach($likes as $like)
            {
                $this->Likees[] = new Like(
                    new LikeId($like['id']),
                    $user_repo->withId(new UserId($like['owner'])),
                    $user_repo->withId(new UserId($like['receiver'])),
                    $like['created_on']
                );
            }
            return $this->Likees;
        }
        return null;
    }
}
