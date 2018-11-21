<?php

namespace App\Application\Message;

use App\Domain\Match\Message\MessageFactory;
use App\Domain\Match\Message\MessageRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\UserRepoInterface;
use App\Domain\Match\MatchRepoInterface;


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
        $sender   = $this->user_repo->withId(new UserId($request->sender_id));
        $receiver = $this->user_repo->withId(new UserId($request->receiver_id));

        $message = MessageFactory::build(
            $this->message_repo->nextId(),
            $request->match_id,
            $sender,
            $receiver,
            $request->body
        );

        $this->message_repo->add($message);

        return $message;
    }
}
