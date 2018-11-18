<?php

namespace App\Domain\Match;

use JsonSerializable;
use App\Domain\User\UserInterface;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\Match\Message\Message;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\CreatedOn\CreatedOnInterface;
use App\Domain\Match\Exceptions\InvalidUsersMatchException;
use App\Domain\CreatedOn\CreatedOn;


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
        if(!$this->assertUserLikeOtherUser($first_user, $second_user->getId()))
        {
            throw new InvalidUsersMatchException(
                (string) $first_user->getName(),
                (string) $second_user->getName(),
                1
            );
        }

        $this->id         = $id;
        $this->users[]    = (string) $first_user->getId();
        $this->users[]    = (string) $second_user->getId();
        $this->created_on = $created_on;
    }

    private function assertUserLikeOtherUser(
        UserInterface $user,
        UserIdInterface $second_user)
    {
        return $user->likesUser($second_user);
    }

    private function assertArrayKeysExist(Array $array, Array $keys)
    {
        foreach($keys as $key)
        {
            if(!array_key_exists($key, $array))
            {
                return false;
            }
        }
        return true;
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

    public function addMessage(Array $message_components)
    {
        if(!$this->assertArrayKeysExist())
        {
            throw new \Exception('Message components doesn\'t have all required keys', 1);
        }
        // Assert that the Array contains all the components
        $this->messages[] = new Message(
            $message_components['id'],
            $this->getId(),
            $message_components['sender'],
            $message_components['receiver'],
            $message_components['body'],
            new CreatedOn()
        );
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getMessageCount()
    {
        return count($this->messages);
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
