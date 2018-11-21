<?php

namespace App\Domain\Match\MatchId;


class MatchId implements MatchIdInterface
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

    public function isEqual(MatchIdInterface $id)
    {
        return $this->getId() === $id->getId();
    }

    public function __toString()
    {
        return $this->getId();
    }
}
