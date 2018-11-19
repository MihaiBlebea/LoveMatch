<?php

namespace App\Domain\User;

use App\Domain\User\UserId\UserId;
use App\Domain\User\Name\Name;
use App\Domain\User\BirthDate\BirthDate;
use App\Domain\User\Gender\Gender;
use App\Domain\User\Email\Email;
use App\Domain\User\Password\Password;
use App\Domain\CreatedOn\CreatedOn;


class UserFactory
{
    public static function build(
        $id,
        String $name,
        String $birth_date,
        String $gender,
        String $email,
        String $password,
        String $created_on = null)
    {
        return new User(
            new UserId($id),
            new Name($name),
            new BirthDate($birth_date),
            new Gender($gender),
            new Email($email),
            new Password($password),
            new CreatedOn($created_on)
        );
    }
}
