<?php

namespace App\Domain\Match\Message\MessageId;


class MessageId implements MessageIdInterface
{
    private $id;


    public function __construct(String $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isEqual(MessageIdInterface $id)
    {
        return $this->getId() === $id->getId();
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
