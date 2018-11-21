<?php

namespace App\Infrastructure\Persistence\Action;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\User\Action\ActionId\ActionId;
use App\Domain\User\Action\ActionId\ActionIdInterface;
use App\Domain\User\Action\ActionInterface;
use App\Domain\User\Action\ActionRepoInterface;
use App\Domain\User\Action\ActionFactory;
use App\Domain\User\UserId\UserIdInterface;


class DominoActionRepo implements ActionRepoInterface
{
    private $persist;

    private $actions = [];


    public function __construct($persist = null)
    {
        $this->persist = $persist;
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
            $this->persist->table('actions')->where('id', (string) $saved_action->getId())->update([
                'type'        => (string) $action->getType(),
                'sender_id'   => (string) $action->getSenderId()->getId(),
                'receiver_id' => (string) $action->getReceiverId()->getId()
            ]);
        } else {
            $this->persist->table('actions')->create([
                'id'          => (string) $action->getId(),
                'type'        => (string) $action->getType(),
                'sender_id'   => (string) $action->getSenderId()->getId(),
                'receiver_id' => (string) $action->getReceiverId()->getId(),
                'created_on'  => (string) $action->getCreatedOn()
            ]);
        }
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
        $this->persist->table('actions')->where('id', (string) $like->getId())->delete();
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
        $action = $this->persist->table('actions')
                                ->where('id', (string) $id->getId())
                                ->selectOne();
        if($action)
        {
            return ActionFactory::build(
                $action['id'],
                $action['type'],
                $action['sender_id'],
                $action['receiver_id'],
                $action['created_on']
            );
        }
        return null;
    }

    public function withSenderId(UserIdInterface $id)
    {
        $actions = $this->persist->table('actions')
                                 ->where('sender_id', (string) $id->getId())
                                 ->select();

        if(count($actions) > 0)
        {
            foreach($actions as $action)
            {
                $this->actions[] = ActionFactory::build(
                    $action['id'],
                    $action['type'],
                    $action['sender_id'],
                    $action['receiver_id'],
                    $action['created_on']
                );
            }
            return $this->actions;
        }
        return null;
    }

    public function withUserIds(UserIdInterface $sender_id, UserIdInterface $receiver_id)
    {
        $action = $this->persist->table('actions')
                              ->where('sender_id', (string) $sender_id->getId())
                              ->where('receiver_id', (string) $receiver_id->getId())
                              ->selectOne();

        if($action)
        {
            return ActionFactory::build(
                $action['id'],
                $action['type'],
                $action['sender_id'],
                $action['receiver_id'],
                $action['created_on']
            );
        }
        return null;
    }
}
