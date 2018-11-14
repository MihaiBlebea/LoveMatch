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
        UserIdInterface $sender_id,
        UserIdInterface $receiver_id,
        CreatedOnInterface $created_on);

    public function getId();

    public function getType();

    public function setType(
        TypeInterface $type,
        CreatedOnInterface $created_on);

    public function getSenderId();

    public function getReceiverId();

    public function getCreatedOn();

    public function JsonSerialize();
}
