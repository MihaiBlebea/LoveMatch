<?php

namespace App\Infrastructure\Persistence\Message;

use Ramsey\Uuid\Uuid;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\Message\MessageInterface;
use App\Domain\Match\Message\MessageId\MessageId;
use App\Domain\Match\Message\MessageId\MessageIdInterface;
use App\Domain\Match\Message\MessageRepoInterface;


class InMemoryMessageRepo implements MessageRepoInterface
{
    private $messages = [];


    public function __construct($persist = null)
    {
        //
    }

    public function nextId()
    {
        return new MessageId(strtoupper(Uuid::uuid4()));
    }

    public function add(MessageInterface $message)
    {
        $saved_message = $this->withId($message->getId());

        if($saved_message)
        {
            $this->remove($saved_message);
        }
        $this->messages[] = $message;
    }

    public function addAll(Array $messages)
    {
        foreach($messages as $message)
        {
            $this->add($message);
        }
    }

    public function remove(MessageInterface $message)
    {
        foreach($this->messages as $saved_message)
        {
            if($saved_message->getId()->isEqual($message->getId()))
            {
                unset($saved_message);
            }
        }
        array_values($this->messages);
    }

    public function removeAll(Array $messages)
    {
        foreach($messages as $message)
        {
            $this->remove($message);
        }
    }

    public function withId(MessageIdInterface $id)
    {
        foreach($this->messages as $message)
        {
            if($message->getId()->isEqual($id))
            {
                return $message;
            }
        }
        return null;
    }

    public function withMatchId(MatchIdInterface $id)
    {
        foreach($this->messages as $message)
        {
            if($message->getMatchId()->isEqual($id))
            {
                return $message;
            }
        }
        return null;
    }
}
