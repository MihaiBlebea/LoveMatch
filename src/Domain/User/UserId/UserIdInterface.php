<?php

namespace App\Domain\User\UserId;


interface UserIdInterface
{
    public function __construct($id);

    public function getId();

    public function __toString();

    public function isEqual(UserIdInterface $id);
}
