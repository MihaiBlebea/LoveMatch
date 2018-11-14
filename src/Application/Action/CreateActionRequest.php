<?php

namespace App\Application\Action;


class CreateActionRequest implements CreateActionRequestInterface
{
    private $sender_id;

    private $receiver_id;

    private $type;

    public function __construct(
        String $type,
        String $sender_id,
        String $receiver_id)
    {
        $this->sender_id   = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->type        = $type;
    }

    public function getActionType()
    {
        return $this->type;
    }

    public function getSenderId()
    {
        return $this->sender_id;
    }

    public function getReceiverId()
    {
        return $this->receiver_id;
    }
}
