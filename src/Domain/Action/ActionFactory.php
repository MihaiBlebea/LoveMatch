<?php

namespace App\Domain\Action;

use App\Domain\CreatedOn\CreatedOn;
use App\Domain\Action\Action;
use App\Domain\Action\ActionId\ActionId;
use App\Domain\Action\Type\Type;
use App\Domain\User\UserId\UserId;


class ActionFactory
{
    public static function build(
        String $id,
        String $type,
        String $sender_id,
        String $receiver_id)
    {
        return new Action(
            new ActionId($id),
            new Type($type),
            new UserId($sender_id),
            new UserId($receiver_id),
            new CreatedOn());
    }
}
