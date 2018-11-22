<?php

namespace App\Domain\User\Image;

use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Image\ImageId\ImageIdInterface;
use App\Domain\User\Image\Path\PathInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


interface ImageInterface
{
    public function __construct(
        ImageIdInterface $id,
        UserIdInterface $user_id,
        PathInterface $path,
        CreatedOnInterface $created_on);

    public function getId();

    public function getUserId();

    public function getPath();

    public function getCreatedOn();

    public function jsonSerialize();
}
