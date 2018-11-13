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
use App\Domain\User\UserId\UserIdInterface;


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
        $this->persist->table('likes')->create([
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
        $this->persist->table('likes')->where('id', (string) $like->getId())->delete();
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
        $like = $this->persist->table('likes')->where('id', $id)->selectOne();
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
        $likes = $this->persist->table('likes')->where('owner', (string) $id->getId())->select();

        if(count($likes) > 0)
        {
            $user_repo = new UserRepo($this->persist);
            foreach($likes as $like)
            {
                $this->likes[] = new Like(
                    new LikeId($like['id']),
                    $user_repo->withId(new UserId($like['owner'])),
                    $user_repo->withId(new UserId($like['receiver'])),
                    $like['created_on']
                );
            }
            return $this->likes;
        }
        return null;
    }

    public function withUserIds(UserIdInterface $user_a_id, UserIdInterface $user_b_id)
    {
        $like = $this->persist->table('likes')
                              ->where('owner', (string) $user_a_id->getId())
                              ->where('receiver', (string) $user_b_id->getId())
                              ->selectOne();

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
}
