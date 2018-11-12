<?php

namespace App\Application\Pass;


interface PassUserRequestInterface
{
    public function __construct(String $owner_id, String $receiver_id);

    public function getOwnerId();

    public function getReceiverId();
}
