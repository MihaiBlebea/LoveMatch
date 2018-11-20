<?php

use PHPUnit\Framework\TestCase;

use App\Infrastructure\Persistence\User\InMemoryUserRepo;
use App\Application\User\UserRegister\UserRegisterService;
use App\Application\User\UserRegister\UserRegisterRequest;
use App\Application\User\UserLogin\UserLoginService;
use App\Application\User\UserLogin\UserLoginRequest;
use App\Application\User\UserLogin\ValidateUserTokenService;
use App\Application\User\UserLogin\ValidateTokenRequest;


class UserTest extends TestCase
{
    private $user_repo;

    private $register_serv;

    private $login_serv;

    private $token_serv;

    private $saved_user;


    public function setUp()
    {
        $this->user_repo     = new InMemoryUserRepo();
        $this->register_serv = new UserRegisterService($this->user_repo);
        $this->login_serv    = new UserLoginService($this->user_repo);
        $this->token_serv    = new ValidateUserTokenService($this->user_repo);

        $this->saved_user = $this->register_serv->execute(new UserRegisterRequest(
            'Mihai Blebea',
            '1989-11-07',
            'MALE',
            'mihai.blebea@slalom.com',
            'intrex'
        ));
    }

    public function testUserCanRegister()
    {
        $this->assertEquals((string) $this->saved_user->getName(), 'Mihai Blebea');
        $this->assertEquals((string) $this->saved_user->getBirthDate(), '1989-11-07');
        $this->assertEquals((string) $this->saved_user->getGender(), 'MALE');
        $this->assertEquals((string) $this->saved_user->getEmail(), 'mihai.blebea@slalom.com');
    }

    public function testUserCanLogin()
    {
        $user = $this->login_serv->execute(new UserLoginRequest(
            'mihai.blebea@slalom.com',
            'intrex'
        ));

        $this->assertEquals((string) $user->getName(), 'Mihai Blebea');
        $this->assertEquals((string) $user->getBirthDate(), '1989-11-07');
        $this->assertEquals((string) $user->getGender(), 'MALE');
        $this->assertEquals((string) $user->getEmail(), 'mihai.blebea@slalom.com');
        $this->assertEquals((string) $this->saved_user->getToken(), (string) $user->getToken());
    }

    public function testValidateUserToken()
    {
        $user = $this->token_serv->execute(new ValidateTokenRequest((string) $this->saved_user->getToken()));

        $this->assertEquals((string) $user->getName(), 'Mihai Blebea');
        $this->assertEquals((string) $user->getBirthDate(), '1989-11-07');
        $this->assertEquals((string) $user->getGender(), 'MALE');
        $this->assertEquals((string) $user->getEmail(), 'mihai.blebea@slalom.com');
    }

}
