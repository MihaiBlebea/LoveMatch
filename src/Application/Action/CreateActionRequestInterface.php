<?php

namespace App\Application\Action;


interface CreateActionRequestInterface
{
    public function __construct(
        String $type,
        String $owner_id,
        String $receiver_id);

    public function getActionType();

    public function getSenderId();

    public function getReceiverId();
}
