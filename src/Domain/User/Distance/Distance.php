<?php

namespace App\Domain\User\Distance;


class Distance implements DistanceInterface
{
    private $distance;


    public function __construct(Int $distance)
    {
        if(!$this->assertBetweenIntegers($distance))
        {
            throw new \Exception('Distance must be between 0 and 100', 1);
        }
        $this->distance = $distance;
    }

    private function assertBetweenIntegers(Int $distance)
    {
        return $distance < 100 && $distance > 0;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function __toString()
    {
        return (string) $this->getDistance();
    }
}
