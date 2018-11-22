<?php

namespace App\Application\User\AttachImage;


class AttachImageRequest implements AttachImageRequestInterface
{
    public $user_id;

    public $image_path;


    public function __construct(String $user_id, String $image_path)
    {
        $this->user_id    = $user_id;
        $this->image_path = $image_path;
    }
}
