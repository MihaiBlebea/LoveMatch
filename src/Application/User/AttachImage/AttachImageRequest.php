<?php

namespace App\Application\User\AttachImage;


class AttachImageRequest implements AttachImageRequestInterface
{
    public $user_id;

    public $images_path;


    public function __construct(String $user_id, Array $images_path)
    {
        $this->user_id    = $user_id;
        $this->image_path = $images_path;
    }
}
