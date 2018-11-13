<?php

namespace App\Application\Message;


class SendMessageRequest implements SendMessageRequestInterface
{
    private $sender_id;

    private $receiver_id;

    private $match_id;

    private $message_body;


    public function __construct(
        String $sender_id,
        String $receiver_id,
        String $match_id,
        String $message_body)
    {
        $this->sender_id    = $sender_id;
        $this->receiver_id  = $receiver_id;
        $this->match_id     = $match_id;
        $this->message_body = $message_body;
    }

    public function getMatchId()
    {
        return $this->match_id;
    }

    public function getSenderId()
    {
        return $this->sender_id;
    }

    public function getReceiverId()
    {
        return $this->receiver_id;
    }

    public function getMessageBody()
    {
        return $this->message_body;
    }
}
