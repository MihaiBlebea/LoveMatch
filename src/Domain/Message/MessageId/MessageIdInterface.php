<?php

namespace App\Domain\Message\MessageId;


interface MessageIdInterface
{
    public function __construct($id);

    public function getId();

    public function __toString();
}
