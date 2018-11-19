<?php

namespace App\Domain\Match\Message\Body;


interface BodyInterface
{
    public function __construct(String $body);

    public function getBody();

    public function __toString();
}
