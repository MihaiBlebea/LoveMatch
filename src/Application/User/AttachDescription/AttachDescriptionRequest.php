<?php

namespace App\Application\User\AttachDescription;


class AttachDescriptionRequest implements AttachDescriptionRequestInterface
{
    public $description;

    public $user_id;


    public function __construct(
        String $description,
        String $user_id)
    {
        $this->description = $description;
        $this->user_id     = $user_id;
    }
}
