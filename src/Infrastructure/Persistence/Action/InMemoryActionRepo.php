<?php

namespace App\Infrastructure\Persistence\Action;

use Ramsey\Uuid\Uuid;
use App\Domain\User\Action\ActionId\ActionId;
use App\Domain\User\Action\ActionId\ActionIdInterface;
use App\Domain\User\Action\ActionInterface;
use App\Domain\User\Action\ActionRepoInterface;
use App\Domain\User\UserId\UserIdInterface;


class InMemoryActionRepo implements ActionRepoInterface
{
    private $actions = [];


    public function __construct($persist = null)
    {
        //
    }

    public function nextId()
    {
        return new ActionId(strtoupper(Uuid::uuid4()));
    }

    public function add(ActionInterface $action)
    {
        $saved_action = $this->withId($action->getId());

        if($saved_action)
        {
            $this->remove($saved_action);
        }
        $this->actions[] = $action;
    }

    public function addAll(Array $actions)
    {
        foreach($actions as $action)
        {
            $this->add($action);
        }
    }

    public function remove(ActionInterface $action)
    {
        foreach($this->actions as $saved_action)
        {
            if($saved_action->getId()->isEqual($action->getId()))
            {
                unset($saved_action);
            }
        }
        array_values($this->actions);
    }

    public function removeAll(Array $actions)
    {
        foreach($actions as $action)
        {
            $this->remove($action);
        }
    }

    public function withId(ActionIdInterface $id)
    {
        foreach($this->actions as $action)
        {
            if($action->getId()->isEqual($id))
            {
                return $action;
            }
        }
        return null;
    }

    public function withSenderId(UserIdInterface $id)
    {
        foreach($this->actions as $action)
        {
            if($action->getSenderId()->isEqual($id))
            {
                return $action;
            }
        }
        return null;
    }

    public function withUserIds(UserIdInterface $sender_id, UserIdInterface $receiver_id)
    {
        foreach($this->actions as $action)
        {
            if($action->getSenderId()->isEqual($sender_id) &&
                $action->getReceiverId()->isEqual($receiver_id))
            {
                return $action;
            }
        }
        return null;
    }
}
