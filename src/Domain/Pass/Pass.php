<?php

namespace App\Domain\Pass;


class Pass
{
    private $id;

    private $owner;

    private $receiver;

    private $date_time;
    

    public function __construct($id, $owner, $receiver)
    {
        $this->id        = $id;
        $this->owner     = $owner;
        $this->receiver  = $receiver;
        $this->date_time = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }
}
