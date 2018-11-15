<?php

use PHPUnit\Framework\TestCase;

use App\Application\User\UserRegisterService;
use App\Infrastructure\User\UserRepo;
use Domino\Persistence;
use Domino\Connector;
use App\Application\User\UserRegisterRequest;


class UserTest extends TestCase
{
    private $connector;

    private $persist;

    private $user_repo;

    private $register_serv;


    public function setUp()
    {
        $this->connector     = new Connector('mysql', 'love_match', 'root', 'root');
        $this->persist       = new Persistence($this->connector);
        $this->user_repo     = new UserRepo($this->persist);
        $this->register_serv = new UserRegisterService($this->user_repo);
    }

    public function testUserCanRegister()
    {
        $user = $this->register_serv->execute(new UserRegisterRequest(
            'Mihai Blebea',
            '1989-11-07',
            'mihai.blebea@slalom.com',
            'intrex'
        ));
        $this->assertEquals((string) $user->getName(), 'Mihai Blebea');
    }

}
