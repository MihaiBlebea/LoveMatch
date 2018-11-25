<?php

namespace App\Domain\User\Distance;


interface DistanceInterface
{
    public function __construct(Int $distance);

    public function getDistance();

    public function __toString();
}
