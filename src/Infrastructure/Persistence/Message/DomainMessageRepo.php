<?php

namespace App\Infrastructure\Persistence\Message;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\Message\MessageInterface;
use App\Domain\Match\Message\MessageId\MessageId;
use App\Domain\Match\Message\MessageId\MessageIdInterface;
use App\Domain\Match\Message\MessageRepoInterface;
use App\Domain\Match\Message\MessageFactory;
use App\Domain\User\UserId\UserId;
use App\Infrastructure\User\UserRepo;


class DomainMessageRepo implements MessageRepoInterface
{
    private $persist;

    private $messages = [];


    public function __construct($persist = null)
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
            return $this->buildMessage($message);
        }
        return null;
    }

    public function withMatchId(MatchIdInterface $id)
    {
        $messages = $this->persist->table('messages')
                                  ->where('match_id', (string) $id->getId())
                                  ->select();

        if($messages && count($messages) > 0)
        {
            foreach($messages as $message)
            {
                $this->messages[] = $this->buildMessage($message);
            }
            return $this->messages;
        }
        return null;
    }

    private function buildMessage(Array $message)
    {
        $user_repo = new UserRepo($this->persist);

        return MessageFactory::build(
            $message['id'],
            $message['match_id'],
            $user_repo->withId(new UserId($message['sender'])),
            $user_repo->withId(new UserId($message['receiver'])),
            $message['body'],
            $message['created_on']
        );
    }
}
