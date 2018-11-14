<?php

namespace App\Application\Message;

use App\Domain\Match\MatchId\MatchId;
use App\Domain\Message\Message;
use App\Domain\Message\Body\Body;
use App\Domain\Message\MessageRepoInterface;
use App\Domain\User\UserRepoInterface;
use App\Domain\Match\MatchRepoInterface;
use App\Domain\User\UserId\UserId;



class SendMessageService
{
    private $message_repo;

    private $user_repo;

    private $match_repo;


    public function __construct(
        MessageRepoInterface $message_repo,
        UserRepoInterface $user_repo,
        MatchRepoInterface $match_repo)
    {
        $this->message_repo = $message_repo;
        $this->user_repo    = $user_repo;
        $this->match_repo   = $match_repo;
    }

    public function execute(SendMessageRequestInterface $request)
    {
        $match    = $this->match_repo->withId(new MatchId($request->getMatchId()));
        $sender   = $this->user_repo->withId(new UserId($request->getSenderId()));
        $receiver = $this->user_repo->withId(new UserId($request->getReceiverId()));

        $message = new Message(
            $this->message_repo->nextId(),
            $sender,
            $receiver,
            new Body($request->getMessageBody()),
            $match);

        $this->message_repo->add($message);
    }
}
