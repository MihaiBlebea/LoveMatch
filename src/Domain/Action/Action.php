<?php

namespace App\Domain\Action;

use JsonSerializable;
use App\Domain\CreatedOn\CreatedOnInterface;
use App\Domain\Action\ActionInterface;
use App\Domain\Action\ActionId\ActionIdInterface;
use App\Domain\Action\Type\TypeInterface;
use App\Domain\User\UserId\UserIdInterface;


class Action implements ActionInterface, JsonSerializable
{
    private $id;

    private $type;

    private $sender_id;

    private $receiver_id;

    private $created_on;


    public function __construct(
        ActionIdInterface $id,
        TypeInterface $type,
        UserIdInterface $sender_id,
        UserIdInterface $receiver_id,
        CreatedOnInterface $created_on)
    {
        $this->id          = $id;
        $this->type        = $type;
        $this->sender_id   = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->created_on  = $created_on;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(
        TypeInterface $type,
        CreatedOnInterface $created_on)
    {
        $this->type       = $type;
        $this->created_on = $created_on;
    }

    public function getSenderId()
    {
        return $this->sender_id;
    }

    public function getReceiverId()
    {
        return $this->receiver_id;
    }

    public function getCreatedOn()
    {
        return $this->created_on;
    }

    public function JsonSerialize()
    {
        return [
            'id'    => (string) $this->getId(),
            'type'  => (string) $this->getType(),
            'users' => [
                'sender'   => (string) $this->getSenderId(),
                'receiver' => (string) $this->getReceiverId()
            ],
            'created_on' => (string) $this->getCreatedOn()
        ];
    }
}
