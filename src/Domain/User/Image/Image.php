<?php

namespace App\Domain\User\Image;

use JsonSerializable;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Image\ImageId\ImageIdInterface;
use App\Domain\User\Image\Path\PathInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


class Image implements ImageInterface, JsonSerializable
{
    private $id;

    private $user_id;

    private $path;

    private $created_on;


    public function __construct(
        ImageIdInterface $id,
        UserIdInterface $user_id,
        PathInterface $path,
        CreatedOnInterface $created_on)
    {
        $this->id         = $id;
        $this->user_id    = $user_id;
        $this->path       = $path;
        $this->created_on = $created_on;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getCreatedOn()
    {
        return $this->created_on;
    }

    public function jsonSerialize()
    {
        return [
            'id'         => (string) $this->getId(),
            'user_id'    => (string) $this->getUserId(),
            'path'       => (string) $this->getPath(),
            'created_on' => (string) $this->getCreatedOn()
        ];
    }
}
