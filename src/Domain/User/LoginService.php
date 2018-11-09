<?php

namespace App\Domain\User;

use App\Domain\User\{
    Email\EmailInterface,
    Password\PasswordInterface
};


class LoginService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(
        EmailInterface $email,
        PasswordInterface $password)
    {
        $user = $this->user_repo->withEmail($email);
        if($user && $user->getPassword()->verifyPassword((string) $password->getPassword()))
        {
            $_SESSION['auth'] = $user->getId();
            return $user;
        }
        return null;
    }
}
