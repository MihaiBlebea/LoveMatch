<?php

namespace App\Domain\Match;

use JsonSerializable;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Action\ActionInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


class Match implements MatchInterface, JsonSerializable
{
    private $id;

    private $users = [];

    private $messages = [];

    private $created_on;


    public function __construct(
        MatchIdInterface $id,
        ActionInterface $action_a,
        ActionInterface $action_b,
        CreatedOnInterface $created_on)
    {
        if(!$this->assertActionIsLike($action_a) &&
            !$this->assertActionIsLike($action_b))
        {
            throw new \Exception('Action is not LIKE', 1);
        }

        if(!$this->assertUsersMatch($action_a, $action_b))
        {
            throw new \Exception('Users doesn\'t match', 1);
        }
        $this->id         = $id;
        $this->users[]    = (string) $action_a->getSenderId()->getId();
        $this->users[]    = (string) $action_b->getSenderId()->getId();
        $this->created_on = $created_on;
    }

    private function assertUsersMatch(
        ActionInterface $action_a,
        ActionInterface $action_b)
    {
        $action_a_sender_id   = (string) $action_a->getSenderId()->getId();
        $action_a_receiver_id = (string) $action_a->getReceiverId()->getId();

        $action_b_sender_id   = (string) $action_b->getSenderId()->getId();
        $action_b_receiver_id = (string) $action_b->getReceiverId()->getId();

        if($action_a_sender_id === $action_b_receiver_id &&
            $action_a_receiver_id === $action_b_sender_id)
        {
            return true;
        } else {
            return false;
        }
    }

    private function assertActionIsLike(ActionInterface $action)
    {
        return (string) $action->getType() === 'LIKE';
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function getCreatedOn()
    {
        return $this->created_on;
    }

    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function jsonSerialize()
    {
        return [
            'id'         => (string) $this->getId(),
            'users'      => $this->getUsers(),
            'created_on' => (string) $this->getCreatedOn()
        ];
    }
}
