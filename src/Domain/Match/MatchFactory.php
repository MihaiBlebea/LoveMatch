<?php

namespace App\Domain\Match;

use App\Domain\Action\Action;
use App\Domain\Action\ActionInterface;
use App\Domain\Match\MatchId\MatchId;
use App\Domain\CreatedOn\CreatedOn;


class MatchFactory
{
    public static function build(
        String $id,
        ActionInterface $action_a,
        ActionInterface $action_b,
        String $created_on = null)
    {
        return new Match(
            new MatchId($id),
            $action_a,
            $action_b,
            new CreatedOn($created_on)
        );
    }
}
