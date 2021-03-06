<?php

namespace App\Domain\Match;

use App\Domain\Match\MatchInterface;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\Match\MatchId\MatchIdInterface;


interface MatchRepoInterface
{
    public function __construct($persist = null);

    public function nextId();

    public function add(MatchInterface $match);

    public function addAll(Array $matches);

    public function remove(MatchInterface $match);

    public function removeAll(Array $matches);

    public function withId(MatchIdInterface $id);

    public function withUserId(UserIdInterface $id);
}
