<?php

namespace App\Domain\User\UserId;


class UserId implements UserIdInterface
{
    private $id;


    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function isEqual(UserIdInterface $id)
    {
        return $this->getId() === $id->getId();
    }
}
