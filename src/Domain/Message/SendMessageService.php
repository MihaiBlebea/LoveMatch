<?php

namespace App\Domain\Message;

use App\Domain\User\UserRepoInterface;


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
    }

    public function execute($match_id, )
    {
        $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
        $mihai = $user_repo->withEmail(new Email('mihaiserban.blebea@gmail.com'));
        $cristina = $user_repo->withEmail(new Email('cristinaliman@gmail.com'));

        $message_repo = $container->get(App\Infrastructure\Message\MessageRepo::class);

        $message = new Message(
            $message_repo->nextId(),
            $mihai,
            $cristina,
            new Body('Ce mai faci Cristina?'));

        $message_repo->add($message);
    }
}
