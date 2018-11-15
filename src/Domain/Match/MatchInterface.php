<?php

namespace App\Domain\Match;

use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Action\ActionInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


interface MatchInterface
{
    public function __construct(
        MatchIdInterface $id,
        ActionInterface $action_a,
        ActionInterface $action_b,
        CreatedOnInterface $created_on);

    public function getId();

    public function getUsers();

    public function getCreatedOn();

    public function jsonSerialize();
}
