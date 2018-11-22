<?php

namespace App\Application\User\AttachDescription;


interface AttachDescriptionRequestInterface
{
    public function __construct(
        String $description,
        String $user_id);
}
