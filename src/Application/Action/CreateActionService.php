<?php

namespace App\Application\Action;

use App\Domain\Action\ActionRepoInterface;
use App\Domain\Action\ActionFactory;


class CreateActionService
{
    private $action_repo;


    public function __construct(ActionRepoInterface $action_repo)
    {
        $this->action_repo = $action_repo;
    }

    public function execute(CreateActionRequestInterface $request)
    {
        $action = ActionFactory::build(
            $this->action_repo->nextId(),
            $request->getActionType(),
            $request->getSenderId(),
            $request->getReceiverId()
        );
        $this->action_repo->add($action);
        return $action;
    }
}
