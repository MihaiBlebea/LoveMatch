<?php

use PHPUnit\Framework\TestCase;

use App\Infrastructure\Persistence\Match\InMemoryMatchRepo;
use App\Infrastructure\Persistence\User\InMemoryUserRepo;
use App\Infrastructure\Persistence\Action\InMemoryActionRepo;
use App\Infrastructure\Persistence\Message\InMemoryMessageRepo;
use App\Application\Match\CreateMatch\CreateMatchService;
use App\Application\Match\CreateMatch\CreateMatchRequest;
use App\Application\Match\GetMatches\GetMatchesService;
use App\Application\Match\GetMatches\GetMatchesRequest;
use App\Application\User\UserRegister\UserRegisterService;
use App\Application\User\UserRegister\UserRegisterRequest;
use App\Application\Action\CreateActionService;
use App\Application\Action\CreateActionRequest;
use App\Application\Message\SendMessageService;
use App\Application\Message\SendMessageRequest;


class MatchTest extends TestCase
{
    public function setUp()
    {
        $this->match_repo   = new InMemoryMatchRepo();
        $this->message_repo = new InMemoryMessageRepo();
        $this->user_repo    = new InMemoryUserRepo();
        $this->action_repo  = new InMemoryActionRepo();

        $this->create_match_serv  = new CreateMatchService($this->match_repo, $this->user_repo);
        $this->register_serv      = new UserRegisterService($this->user_repo);
        $this->create_action_serv = new CreateActionService($this->action_repo, $this->user_repo);
        $this->send_message_serv  = new SendMessageService($this->message_repo, $this->user_repo, $this->match_repo);


        $this->first_user = $this->register_serv->execute(new UserRegisterRequest(
            'Mihai Blebea',
            '1989-11-07',
            'MALE',
            'mihai.blebea@slalom.com',
            'intrex'
        ));

        $this->second_user = $this->register_serv->execute(new UserRegisterRequest(
            'Cristina Aliman',
            '1986-04-11',
            'FEMALE',
            'cristinaliman@gmail.com',
            'intrex'
        ));

        $this->first_user->addAction($this->create_action_serv->execute(new CreateActionRequest(
            'LIKE',
            (string) $this->first_user->getId(),
            (string) $this->second_user->getId()
        )));

        $this->second_user->addAction($this->create_action_serv->execute(new CreateActionRequest(
            'LIKE',
            (string) $this->first_user->getId(),
            (string) $this->second_user->getId()
        )));
    }

    public function testCreateMatch()
    {
        $match = $this->create_match_serv->execute(new CreateMatchRequest(
            (string) $this->first_user->getId(),
            (string) $this->second_user->getId()
        ));

        $this->assertEquals($match->getUsers()[0], (string) $this->first_user->getId());
        $this->assertEquals($match->getUsers()[1], (string) $this->second_user->getId());
    }

    public function testGetMessages()
    {
        $match = $this->create_match_serv->execute(new CreateMatchRequest(
            (string) $this->first_user->getId(),
            (string) $this->second_user->getId()
        ));

        $get_matches_serv = new GetMatchesService($this->match_repo);

        $matches = $get_matches_serv->execute(new GetMatchesRequest((string) $this->first_user->getId()));

        $this->assertEquals((string) $matches[0]->getId(), (string) $match->getId());
        $this->assertEquals($matches[0]->getUsers()[0], (string) $this->first_user->getId());
        $this->assertEquals($matches[0]->getUsers()[1], (string) $this->second_user->getId());
    }

    public function testSendMessage()
    {
        $match = $this->create_match_serv->execute(new CreateMatchRequest(
            (string) $this->first_user->getId(),
            (string) $this->second_user->getId()
        ));

        $message = $this->send_message_serv->execute(new SendMessageRequest(
            (string) $this->first_user->getId(),
            (string) $this->second_user->getId(),
            (string) $match->getId(),
            'Ce faci Cristina?'
        ));

        $match->addMessage($message);

        $this->assertEquals((string) $match->getMessages()[0]->getId(), (string) $message->getId());
        $this->assertEquals((string) $match->getMessages()[0]->getSender()->getId(), (string) $this->first_user->getId());
        $this->assertEquals((string) $match->getMessages()[0]->getReceiver()->getId(), (string) $this->second_user->getId());
    }
}
