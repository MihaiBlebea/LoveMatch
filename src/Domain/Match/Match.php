<?php

namespace App\Domain\Match;

use JsonSerializable;
use App\Domain\User\UserInterface;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\Message\MessageInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


class Match implements MatchInterface, JsonSerializable
{
    private $id;

    private $users = [];

    private $messages = [];

    private $created_on;


    public function __construct(
        MatchIdInterface $id,
        UserInterface $first_user,
        UserInterface $second_user,
        CreatedOnInterface $created_on)
    {
        $this->id         = $id;
        $this->users[]    = (string) $first_user->getId();
        $this->users[]    = (string) $second_user->getId();
        $this->created_on = $created_on;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function getCreatedOn()
    {
        return $this->created_on;
    }

    public function addMessage(MessageInterface $message)
    {
        $this->messages[] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getSenderMessages(UserIdInterface $owner_id)
    {
        $messages = [];
        foreach($this->getMessages() as $message)
        {
            if((string) $message->getSender()->getId() === $owner_id)
            {
                $messages[] = $message;
            }
        }
        return $messages;
    }

    public function getReceiverMessages(UserIdInterface $owner_id)
    {
        $messages = [];
        foreach($this->getMessages() as $message)
        {
            if((string) $message->getReceiver()->getId() === $owner_id)
            {
                $messages[] = $message;
            }
        }
        return $messages;
    }

    public function jsonSerialize()
    {
        return [
            'id'         => (string) $this->getId(),
            'users'      => $this->getUsers(),
            'messages'   => $this->getMessages(),
            'created_on' => (string) $this->getCreatedOn()
        ];
    }
}
