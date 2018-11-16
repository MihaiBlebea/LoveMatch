<?php

namespace App\Domain\Match\Message;

use Domino\Interfaces\PersistenceInterface;


interface MessageRepoInterface
{
    public function __construct(PersistenceInterface $persist);

    public function nextId();

    public function add(Message $message);

    public function addAll(Array $messages);

    public function remove(Message $message);

    public function removeAll(Array $messages);
}
