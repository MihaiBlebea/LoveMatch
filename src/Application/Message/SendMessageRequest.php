<?php

namespace App\Application\Message;


class SendMessageRequest implements SendMessageRequestInterface
{
    public $sender_id;

    public $receiver_id;

    public $match_id;

    public $body;


    public function __construct(
        String $sender_id,
        String $receiver_id,
        String $match_id,
        String $body)
    {
        $this->sender_id   = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->match_id    = $match_id;
        $this->body        = $body;
    }
}
