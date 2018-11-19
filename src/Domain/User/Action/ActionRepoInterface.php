<?php

namespace App\Domain\User\Action;

use Domino\Interfaces\PersistenceInterface;
use App\Domain\User\Action\ActionId\ActionIdInterface;
use App\Domain\User\Action\ActionInterface;
use App\Domain\User\UserId\UserIdInterface;


interface ActionRepoInterface
{
    public function __construct(PersistenceInterface $persist);

    public function nextId();

    public function add(ActionInterface $action);

    public function addAll(Array $actions);

    public function remove(ActionInterface $action);

    public function removeAll(Array $likes);

    public function withId(ActionIdInterface $id);

    public function withSenderId(UserIdInterface $id);

    public function withUserIds(
        UserIdInterface $sender_id,
        UserIdInterface $receiver_id);
}
