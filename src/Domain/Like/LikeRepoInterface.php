<?php

namespace App\Domain\Like;

use Domino\Interfaces\PersistenceInterface;
use App\Domain\Like\LikeId\LikeIdInterface;


interface LikeRepoInterface
{
    public function __construct(PersistenceInterface $persist);

    public function nextId();

    public function add(Pass $pass);

    public function addAll(Array $passes);

    public function remove(Pass $pass);

    public function removeAll(Array $passes);

    public function withId(PassIdInterface $id);

    public function withOwnerId(PassIdInterface $id);
}
