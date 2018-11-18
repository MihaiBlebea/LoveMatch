<?php

namespace App\Domain\Match\Message;

use App\Domain\User\UserInterface;
use App\Domain\Match\MatchId\MatchId;
use App\Domain\Match\Message\MessageId\MessageId;
use App\Domain\Match\Message\MessageId\MessageIdInterface;
use App\Domain\Match\Message\Body\Body;
use App\Domain\CreatedOn\CreatedOn;


class MessageFactory
{
    public static function build(
        String $id,
        String $match_id,
        UserInterface $sender,
        UserInterface $receiver,
        String $body,
        String $created_on = null)
    {
        return new Message(
            new MessageId($id),
            new MatchId($match_id),
            $sender,
            $receiver,
            new Body($body),
            new CreatedOn($created_on)
        );
    }
}
