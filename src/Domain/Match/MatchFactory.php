<?php

namespace App\Domain\Match;

use App\Domain\User\UserInterface;
use App\Domain\Match\MatchId\MatchId;
use App\Domain\CreatedOn\CreatedOn;


class MatchFactory
{
    public static function build(
        String $id,
        UserInterface $first_user,
        UserInterface $second_user,
        String $created_on = null)
    {
        return new Match(
            new MatchId($id),
            $first_user,
            $second_user,
            new CreatedOn($created_on)
        );
    }
}
