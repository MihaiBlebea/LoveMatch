<?php

namespace App\Application\Message;


interface SendMessageRequestInterface
{
    public function __construct(
        String $sender_id,
        String $receiver_id,
        String $match_id,
        String $body);
}
