<?php

namespace App\Domain\Match;

use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\User\User;


class Match
{
    private $id;

    private $active = true;

    private $users = []

    private $conversation = [];

    private $created_on;

    private $date_format = 'Y-m-d H:m:s';


    public function __construct(
        MatchIdInterface $id,
        User $user_a,
        User $user_b,
        $created_on = null)
    {
        $this->id         = $id;
        $this->users[]    = $user_a;
        $this->users[]    = $user_b;
        if($created_on === null)
        {
            $this->created_on = new \DateTime();
        } else {
            $this->created_on = \DateTime::createFromFormat($this->date_format, $created_on);
        }
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

    public function getCreatedOn()
    {
        return $this->created_on->format($this->date_format);
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
