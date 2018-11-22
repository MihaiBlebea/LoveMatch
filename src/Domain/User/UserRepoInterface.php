<?php

namespace App\Domain\User;

use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Email\Emailinterface;
use App\Domain\User\Token\TokenInterface;
use App\Domain\User\Gender\GenderInterface;
use App\Domain\User\Location\LocationInterface;


interface UserRepoInterface
{
    public function __construct($persist = null);

    public function nextId();

    public function add(UserInterface $user);

    public function addAll(Array $users);

    public function remove(UserInterface $user);

    public function removeAll(Array $users);

    public function withId(UserIdInterface $id);

    public function withEmail(EmailInterface $email);

    public function withToken(TokenInterface $token);

    public function all(
        Int $count,
        GenderInterface $gender,
        UserIdInterface $user_id,
        LocationInterface $location,
        Int $distance);
}
