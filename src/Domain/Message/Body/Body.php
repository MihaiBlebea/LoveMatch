<?php

namespace App\Domain\Message\Body;


class Body implements BodyInterface
{
    private $body;


    public function __construct(String $body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function __toString()
    {
        return $this->getBody();
    }
}
