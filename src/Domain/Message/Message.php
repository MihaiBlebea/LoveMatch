<?php

namespace App\Domain\Message;

use App\Domain\User\User;
use App\Domain\Message\MessageId\MessageIdInterface;
use App\Domain\Message\Body\BodyInterface;


class Message
{
    private $id;

    private $sender;

    private $receiver;

    private $body;

    private $sent_on;


    public function __construct(
        MessageIdInterface $id,
        User $sender,
        User $receiver,
        BodyInterface $body,
        $sent_on = null)
    {
        $this->id       = $id;
        $this->sender   = $sender;
        $this->receiver = $receiver;
        $this->body     = $body;
        if($sent_on === null)
        {
            $this->sent_on = new \DateTime();
        } else {
            $this->sent_on = $sent_on;
        }
    }

    public function getId()
    {
        return $this->id;
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

    public function getSentOn()
    {
        return $this->sent_on;
    }
}
