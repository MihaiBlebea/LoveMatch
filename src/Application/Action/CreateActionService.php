<?php

namespace App\Application\Action;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\Action\ActionRepoInterface;
use App\Domain\User\Action\ActionFactory;


class CreateActionService
{
    private $action_repo;

    private $user_repo;


    public function __construct(
        ActionRepoInterface $action_repo,
        UserRepoInterface $user_repo)
    {
        $this->action_repo = $action_repo;
        $this->user_repo   = $user_repo;
    }

    public function execute(CreateActionRequestInterface $request)
    {
        $action = ActionFactory::build(
            $this->action_repo->nextId(),
            $request->type,
            $request->sender_id,
            $request->receiver_id
        );

        $sender = $this->user_repo->withId(new UserId($request->sender_id));
        $sender->addAction($action);

        $this->user_repo->add($sender);

        return $sender;
    }
}
