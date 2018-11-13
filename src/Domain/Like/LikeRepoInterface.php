<?php

namespace App\Domain\Like;

use Domino\Interfaces\PersistenceInterface;
use App\Domain\Like\LikeId\LikeIdInterface;
use App\Domain\User\UserId\UserIdInterface;


interface LikeRepoInterface
{
    public function __construct(PersistenceInterface $persist);

    public function nextId();

    public function add(Like $pass);

    public function addAll(Array $passes);

    public function remove(Like $pass);

    public function removeAll(Array $passes);

    public function withId(LikeIdInterface $id);

    public function withOwnerId(LikeIdInterface $id);

    public function withUserIds(
        UserIdInterface $user_a,
        UserIdInterface $user_b);
}
