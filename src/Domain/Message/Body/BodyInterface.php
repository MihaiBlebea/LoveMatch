<?php

namespace App\Domain\Message\Body;


interface BodyInterface
{
    public function __construct(String $body);

    public function getBody();

    public function __toString();
}
