<?php

namespace App\Domain\User\Action\ActionId;


class ActionId implements ActionIdInterface
{
    private $id;


    public function __construct(String $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isEqual(ActionIdInterface $id)
    {
        return $this->getId() === $id->getId();
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
