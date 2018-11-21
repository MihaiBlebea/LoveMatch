<?php

namespace App\Domain\User\Image;


class Image implements ImageInterface
{
    private $path;


    public function __construct(String $path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return $this->getPath();
    }
}
