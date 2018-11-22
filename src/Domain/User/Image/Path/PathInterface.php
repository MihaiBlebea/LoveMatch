<?php

namespace App\Domain\User\Image\Path;


interface PathInterface
{
    public function __construct(String $id);

    public function getPath();

    public function __toString();
}
