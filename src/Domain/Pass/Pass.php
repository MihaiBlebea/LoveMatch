<?php

namespace App\Domain\Pass;

use App\Domain\Pass\PassId\PassIdInterface;
use App\Domain\User\User;


class Pass
{
    private $id;

    private $owner;

    private $receiver;

    private $created_on;

    private $date_format = 'Y-m-d H:m:s';


    public function __construct(PassIdInterface $id, User $owner, User $receiver, $created_on = null)
    {
        $this->id       = $id;
        $this->owner    = $owner;
        $this->receiver = $receiver;
        if($created_on === null)
        {
            $this->created_on = new \DateTime();
        } else {
            $this->created_on = \DateTime::createFromFormat($this->date_format, $created_on);
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
        return $this->created_on->format($this->date_format);
    }
}
