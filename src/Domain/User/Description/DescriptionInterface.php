<?php

namespace App\Domain\User\Description;


interface DescriptionInterface
{
    public function __construct(String $description);

    public function getDescription();

    public function __toString();
}
