<?php

namespace App\Domain\User;


class UserLogoutService
{
    public static function execute()
    {
        $_SESSION['auth'] = null;
    }
}
