<?php

namespace App\Domain\Match\Message;

use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\Message\MessageInterface;
use App\Domain\Match\Message\MessageId\MessageIdInterface;


interface MessageRepoInterface
{
    public function __construct($persist = null);

    public function nextId();

    public function add(MessageInterface $message);

    public function addAll(Array $messages);

    public function remove(MessageInterface $message);

    public function removeAll(Array $messages);

    public function withId(MessageIdInterface $id);

    public function withMatchId(MatchIdInterface $id);
}
