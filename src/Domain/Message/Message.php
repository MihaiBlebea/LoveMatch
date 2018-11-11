<?php

namespace App\Domain\Message;


class Message
{
    private $id;

    private $sender;

    private $receiver;

    private $body;

    private $send_on;


    public function __construct($id, $sender, $receiver, $body)
    {
        $this->id       = $id;
        $this->sender   = $sender;
        $this->receiver = $receiver;
        $this->body     = $body;
        $this->send_on  = new \DateTime();
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

    public function getSendOn()
    {
        return $this->send_on;
    }
}
