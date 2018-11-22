<?php

namespace App\Application\User\AttachImage;


interface AttachImageRequestInterface
{
    public function __construct(String $user_id, String $image_path);
}
