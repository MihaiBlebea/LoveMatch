<?php

namespace App\Domain\Action;

use App\Domain\CreatedOn\CreatedOnInterface;
use App\Domain\Action\ActionId\ActionIdInterface;
use App\Domain\Action\Type\TypeInterface;
use App\Domain\User\UserId\UserIdInterface;


interface ActionInterface
{
    public function __construct(
        ActionIdInterface $id,
        TypeInterface $type,
        UserIdInterface $sender,
        UserIdInterface $receiver,
        CreatedOnInterface $created_on);

    public function getId();

    public function getType();

    public function setType(
        TypeInterface $type,
        CreatedOnInterface $created_on);

    public function getSender();

    public function getReceiver();

    public function getCreatedOn();

    public function JsonSerialize();
}
