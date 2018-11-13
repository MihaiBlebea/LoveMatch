<?php

namespace App\Application\Like;


interface LikeUserRequestInterface
{
    public function __construct(String $owner_id, String $receiver_id);

    public function getOwnerId();

    public function getReceiverId();
}
