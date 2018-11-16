<?php

namespace App\Infrastructure\Message;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Match\Message\MessageId\MessageId;
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

    public function add(Message $message)
    {
        $this->persist->table('messages')->create([
            'id'       => (string) $message->getId(),
            'sender'   => (string) $message->getSender()->getId(),
            'receiver' => (string) $message->getReceiver()->getId(),
            'body'     => (string) $message->getBody(),
            'match_id' => (string) $message->getMatch()->getId(),
            'sent_on'  => (string) $message->getSentOn()
        ]);
    }

    public function addAll(Array $messages)
    {
        foreach($messages as $message)
        {
            $this->add($message);
        }
    }

    public function remove(Message $message)
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
}
