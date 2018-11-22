<?php

namespace App\Domain\User\Image\ImageId;


interface ImageIdInterface
{
    public function __construct(String $id);

    public function getId();

    public function __toString();
}
