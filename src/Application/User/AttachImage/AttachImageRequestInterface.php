<?php

namespace App\Application\User\AttachImage;


interface AttachImageRequestInterface
{
    public function __construct(String $user_id, Array $images_path);
}
