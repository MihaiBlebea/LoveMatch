<?php

namespace App\Application\Pass;


class PassUserRequest implements PassUserRequestInterface
{
    private $owner_id;

    private $receiver_id;


    public function __construct(String $owner_id, String $receiver_id)
    {
        $this->owner_id    = $owner_id;
        $this->receiver_id = $receiver_id;
    }

    public function getOwnerId()
    {
        return $this->owner_id;
    }

    public function getReceiverId()
    {
        return $this->receiver_id;
    }
}
