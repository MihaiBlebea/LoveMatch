<?php

namespace App\Domain\User\Name;


class Name implements NameInterface
{
    private $name;


    public function __construct(String $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
