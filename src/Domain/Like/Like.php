<?php

namespace App\Domain\Like;

use App\Domain\User\User;
use App\Domain\Like\LikeId\LikeIdInterface;

class Like
{
    private $id;

    private $owner;

    private $receiver;

    private $date_time;


    public function __construct(LikeIdInterface $id, User $owner, User $receiver, $created_on = null)
    {
        $this->id       = $id;
        $this->owner    = $owner;
        $this->receiver = $receiver;
        if($created_on === null)
        {
            $this->created_on = new \DateTime();
        } else {
            $this->created_on = $created_on;
        }
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

    public function getCreatedOn()
    {
        return $this->created_on->format('Y-m-d');
    }
}
