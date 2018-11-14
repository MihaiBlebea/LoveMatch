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

    private $sender;

    private $receiver;

    private $created_on;


    public function __construct(
        ActionIdInterface $id,
        TypeInterface $type,
        UserIdInterface $sender,
        UserIdInterface $receiver,
        CreatedOnInterface $created_on)
    {
        $this->id         = $id;
        $this->type       = $type;
        $this->sender     = $sender;
        $this->receiver   = $receiver;
        $this->created_on = $created_on;
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

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
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
                'sender'   => (string) $this->getSender(),
                'receiver' => (string) $this->getReceiver()
            ],
            'created_on' => (string) $this->getCreatedOn()
        ];
    }
}
