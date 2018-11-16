<?php

namespace App\Domain\Match\Message\MessageId;


interface MessageIdInterface
{
    public function __construct($id);

    public function getId();

    public function __toString();
}
