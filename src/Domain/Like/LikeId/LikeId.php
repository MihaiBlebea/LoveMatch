<?php

namespace App\Domain\Like\LikeId;


class LikeId implements LikeIdInterface
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
