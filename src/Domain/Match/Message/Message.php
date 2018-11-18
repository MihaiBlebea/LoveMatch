<?php

namespace App\Domain\Match\Message;

use JsonSerializable;
use App\Domain\User\UserInterface;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\Message\MessageId\MessageIdInterface;
use App\Domain\Match\Message\Body\BodyInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


class Message implements MessageInterface, JsonSerializable
{
    private $id;

    private $match_id;

    private $sender;

    private $receiver;

    private $body;

    private $created_on;


    public function __construct(
        MessageIdInterface $id,
        MatchIdInterface $match_id,
        UserInterface $sender,
        UserInterface $receiver,
        BodyInterface $body,
        CreatedOnInterface $created_on)
    {
        $this->id         = $id;
        $this->match_id   = $match_id;
        $this->sender     = $sender;
        $this->receiver   = $receiver;
        $this->body       = $body;
        $this->created_on = $created_on;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMatchId()
    {
        return $this->match_id;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCreatedOn()
    {
        return $this->created_on;
    }

    public function jsonSerialize()
    {
        return [
            'id'          => (string) $this->getId(),
            'sender_id'   => (string) $this->getSender()->getId(),
            'receiver_id' => (string) $this->getReceiver()->getId(),
            'body'        => (string) $this->getBody(),
            'created_on'  => (string) $this->getCreatedOn(),
        ];
    }
}
