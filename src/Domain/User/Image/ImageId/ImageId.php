<?php

namespace App\Domain\User\Image\ImageId;


class ImageId implements ImageIdInterface
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

    public function __toString()
    {
        return $this->getId();
    }
}
