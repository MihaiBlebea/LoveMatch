<?php

namespace App\Domain\Pass\PassId;


class PassId implements PassIdInterface
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
}
