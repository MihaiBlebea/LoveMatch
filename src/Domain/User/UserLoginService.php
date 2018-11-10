<?php

namespace App\Domain\User;

use App\Application\UserLoginRequest;


class UserLoginService
{
    private $user_repo;


    public function __construct(UserRepoInterface $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UserLoginRequest $request)
    {
        if($_SESSION['auth'] !== null)
        {
            throw new \Exception('This user or another user is already logged in. Logout first', 1);
        }

        $user = $this->user_repo->withEmail($request->getEmail());
        if($user && $user->getPassword()->verifyPassword((string) $request->getPassword()))
        {
            $_SESSION['auth'] = $user->getId();
            return $user;
        }
        return null;
    }
}
