<?php

namespace App\Domain\User\Image\Path;


class Path implements PathInterface
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
