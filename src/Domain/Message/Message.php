<?php

namespace App\Domain\Message;

use App\Domain\User\User;
use App\Domain\Message\MessageId\MessageIdInterface;
use App\Domain\Message\Body\BodyInterface;
use App\Domain\Match\Match;


class Message
{
    private $id;

    private $sender;

    private $receiver;

    private $body;

    private $match;

    private $sent_on;

    private $date_format = 'Y-m-d H:m:s';


    public function __construct(
        MessageIdInterface $id,
        User $sender,
        User $receiver,
        BodyInterface $body,
        Match $match,
        $sent_on = null)
    {
        if(!$this->assertUsersAreMatched($sender, $receiver, $match))
        {
            throw new \Exception('Users are not matched', 1);
        }

        $this->id       = $id;
        $this->sender   = $sender;
        $this->receiver = $receiver;
        $this->body     = $body;
        $this->match    = $match;
        if($sent_on === null)
        {
            $this->sent_on = new \DateTime();
        } else {
            $this->sent_on = \DateTime::createFromFormat($this->date_format, $sent_on);
        }
    }

    private function assertUsersAreMatched(
        User $sender,
        User $receiver,
        Match $match)
    {
        return in_array((string) $sender->getId(), $match->getUsers()) &&
                in_array((string) $receiver->getId(), $match->getUsers());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getMatch()
    {
        return $this->match;
    }

    public function getSentOn()
    {
        return $this->sent_on->format($this->date_format);
    }
}
