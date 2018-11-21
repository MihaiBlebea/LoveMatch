<?php

namespace App\Domain\Match\Message\MessageId;


interface MessageIdInterface
{
    public function __construct(String $id);

    public function getId();

    public function isEqual(MessageIdInterface $id);

    public function __toString();
}
