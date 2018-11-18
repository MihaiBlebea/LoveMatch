<?php

namespace App\Domain\Match;

use App\Domain\User\UserInterface;
use App\Domain\Match\MatchId\MatchIdInterface;
use App\Domain\Match\Message\MessageInterface;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


interface MatchInterface
{
    public function __construct(
        MatchIdInterface $id,
        UserInterface $first_user,
        UserInterface $second_user,
        CreatedOnInterface $created_on);

    public function getId();

    public function getUsers();

    public function getCreatedOn();

    public function addMessage(MessageInterface $message);

    public function addMessages(Array $messages);

    public function getMessages();

    public function getMessageCount();

    public function getSenderMessages(UserIdInterface $owner_id);

    public function getReceiverMessages(UserIdInterface $owner_id);

    public function jsonSerialize();
}
