<?php

namespace App\Infrastructure\Message;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Match\Message\MessageInterface;
use App\Domain\Match\Message\MessageId\MessageId;
use App\Domain\Match\Message\MessageId\MessageIdInterface;
use App\Domain\Match\Message\MessageRepoInterface;
use App\Domain\Match\Message\Message;


class MessageRepo implements MessageRepoInterface
{
    private $persist;

    private $messages = [];


    public function __construct(PersistenceInterface $persist)
    {
        $this->persist = $persist;
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
            $this->persist->table('messages')->where('id', (string) $message->getId())->update([
                'match_id'   => (string) $message->getMatchId(),
                'sender'     => (string) $message->getSender()->getId(),
                'receiver'   => (string) $message->getReceiver()->getId(),
                'body'       => (string) $message->getBody()
            ]);
        } else {
            $this->persist->table('messages')->create([
                'id'         => (string) $message->getId(),
                'match_id'   => (string) $message->getMatchId(),
                'sender'     => (string) $message->getSender()->getId(),
                'receiver'   => (string) $message->getReceiver()->getId(),
                'body'       => (string) $message->getBody(),
                'created_on' => (string) $message->getCreatedOn()
            ]);
        }
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
        $this->persist->table('messages')->where('id', (string) $message->getId())->delete();
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
        $message = $this->persist->table('messages')
                                 ->where('id', (string) $id->getId())
                                 ->selectOne();
        if($message)
        {
            return new Message(
                $message['id'],
                $message['match_id'],
                $message['sender'],
                $message['receiver'],
                $message['body'],
                $message['created_on']
            );
        }
        return null;
    }
}
