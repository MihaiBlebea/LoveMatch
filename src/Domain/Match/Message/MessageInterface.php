<?php

namespace App\Domain\Match\Message;

use App\Domain\User\UserInterface;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\Message\MessageId\MessageIdInterface;
use App\Domain\Match\Message\Body\BodyInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


interface MessageInterface
{
    public function __construct(
        MessageIdInterface $id,
        MatchIdInterface $match_id,
        UserInterface $sender,
        UserInterface $receiver,
        BodyInterface $body,
        CreatedOnInterface $created_on);

    public function getId();

    public function getMatchId();

    public function getSender();

    public function getReceiver();

    public function getBody();

    public function getCreatedOn();

    public function jsonSerialize();
}
