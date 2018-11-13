<?php

namespace App\Domain\Match;

use Domino\Interfaces\PersistenceInterface;
use App\Domain\Match\MatchId\MatchIdInterface;


interface MatchRepoInterface
{
    public function __construct(PersistenceInterface $persist);

    public function nextId();

    public function add(Match $match);

    public function addAll(Array $matches);

    public function remove(Match $match);

    public function removeAll(Array $matches);

    public function withId(MatchIdInterface $id);
}
