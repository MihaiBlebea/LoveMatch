<?php

namespace App\Domain\User\Name;


interface NameInterface
{
    public function __construct(String $name);

    public function getName();

    public function __toString();
}
