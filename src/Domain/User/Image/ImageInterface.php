<?php

namespace App\Domain\User\Image;


interface ImageInterface
{
    public function __construct(String $path);

    public function getPath();

    public function __toString();
}
