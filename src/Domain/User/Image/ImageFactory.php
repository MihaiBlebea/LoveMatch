<?php

namespace App\Domain\User\Image;

use App\Domain\User\UserId\UserId;
use App\Domain\User\Image\Image;
use App\Domain\User\Image\ImageId\ImageId;
use App\Domain\User\Image\Path\Path;
use App\Domain\CreatedOn\CreatedOn;

class ImageFactory
{
    public static function build(
        String $id,
        String $user_id,
        String $path,
        String $created_on = null)
    {
        return new Image(
            new ImageId($id),
            new UserId($user_id),
            new Path($path),
            new CreatedOn($created_on)
        );
    }
}
