<?php

namespace App\Domain\Action\Type;


interface TypeInterface
{
    public static function pass();

    public static function like();

    public function __construct(String $type);

    public function assertTypeIsAccepted(String $type);

    public function getType();

    public function __toString();
}
