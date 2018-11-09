<?php

namespace App\Domain\User;

use App\Domain\User\{
    UserId\UserId,
    Name\Name,
    BirthDate\BirthDate,
    Email\Email,
    Password\Password
};


class UserFactory
{
    public static function build(
        $id,
        String $name,
        String $birth_date,
        String $email,
        String $password)
    {
        return new User(
            new UserId($id),
            new Name($name),
            new BirthDate($birth_date),
            new Email($email),
            new Password($password)
        );
    }
}
