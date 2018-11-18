<?php

namespace App\Domain\Match\Message;

use Domino\Interfaces\PersistenceInterface;
use App\Domain\Match\Message\MessageInterface;
use App\Domain\Match\Message\MessageId\MessageIdInterface;


interface MessageRepoInterface
{
    public function __construct(PersistenceInterface $persist);

    public function nextId();

    public function add(MessageInterface $message);

    public function addAll(Array $messages);

    public function remove(MessageInterface $message);

    public function removeAll(Array $messages);

    public function withId(MessageIdInterface $id);
}
