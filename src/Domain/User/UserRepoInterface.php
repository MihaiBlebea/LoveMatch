<?php

namespace App\Domain\User;

use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Email\Emailinterface;


interface UserRepoInterface
{
    public function __construct($persist);

    public function nextId();

    public function add(User $user);

    public function addAll(Array $users);

    public function remove(User $user);

    public function removeAll(Array $users);

    public function withId(UserIdInterface $id);

    public function withEmail(EmailInterface $email);
}
