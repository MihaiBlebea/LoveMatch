<?php

namespace App\Domain\User\Image;

use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Image\ImageInterface;
use App\Domain\User\Image\ImageId\ImageIdInterface;


interface ImageRepoInterface
{
    public function __construct($persist = null);

    public function nextId();

    public function add(ImageInterface $image);

    public function addAll(Array $images);

    public function remove(ImageInterface $image);

    public function removeAll(Array $images);

    public function withId(ImageIdInterface $id);

    public function withUserId(UserIdInterface $id);
}
