<?php

namespace App\Domain\Match\Exceptions;

use Exception;


class InvalidUsersMatchException extends Exception
{
    public function __construct(
        String $user_name,
        String $second_user_name,
        $code = 0)
    {
        $message = 'Match pair invalid. User ' . $user_name . ' doesn\'t like user ' . $second_user_name;
        parent::__construct($message, $code, null);
    }
}
