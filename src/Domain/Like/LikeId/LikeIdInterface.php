<?php

namespace App\Domain\Like\LikeId;


interface LikeIdInterface
{
    public function __construct($id);

    public function getId();

    public function __toString();
}
