<?php

namespace App\Domain\User\UserId;


interface UserIdInterface
{
    public function __construct(String $id);

    public function getId();

    public function __toString();

    public function isEqual(UserIdInterface $id);
}
