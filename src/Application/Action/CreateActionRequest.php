<?php

namespace App\Application\Action;


class CreateActionRequest implements CreateActionRequestInterface
{
    public $sender_id;

    public $receiver_id;

    public $type;


    public function __construct(
        String $type,
        String $sender_id,
        String $receiver_id)
    {
        $this->sender_id   = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->type        = $type;
    }
}
