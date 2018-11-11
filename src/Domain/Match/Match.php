<?php

namespace App\Domain\Match;


class Match
{
    private $id;

    private $active = true;

    private $users = []

    private $conversation = [];

    private $started_on;


    public function __construct($id, $user_a, $user_b)
    {
        $this->id         = $id;
        $this->users[]    = $user_a;
        $this->users[]    = $user_b;
        $this->started_on = new \DateTime();;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function getConversation()
    {
        return $this->conversation;
    }

    public function getStartedOn()
    {
        return $this->started_on;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function addMessage($message)
    {
        if(!$this->validateMessage())
        {
            throw new \Exception('Message does not belong to the match users', 1);
        }
        $this->conversation[] = $message
    }

    private function validateMessage($message)
    {
        $sender_id = $message->getSender()->getId();
        $receiver_id = $message->getReceiver()->getId();
        $users_id = [];
        foreach($users as $user)
        {
            $users_id[] = (string) $user->getId();
        }
        if(in_array($sender_id, $users_id) && in_array($receiver_id, $users_id))
        {
            return true;
        }
        return false;
    }
}
