<?php

namespace App\Domain\User\AgeInterval;

use JsonSerializable;


class AgeInterval implements AgeIntervalInterface, JsonSerializable
{
    private $min;

    private $max;


    public function __construct(Int $min, Int $max)
    {
        if(!$this->assertValidMinAge($min))
        {
            throw new \Exception('Min age must be greater or equal to 18', 1);
        }

        if(!$this->assertValidMaxAge($max))
        {
            throw new \Exception('Max age must be less or equal to 65', 1);
        }

        $this->min = $min;
        $this->max = $max;
    }

    private function assertValidMinAge(Int $min)
    {
        return 18 <= $min && $min <= 65;
    }

    private function assertValidMaxAge(Int $max)
    {
        return 18 <= $max && $max <= 65;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function getInterval()
    {
        return [
            'min' => $this->getMin(),
            'max' => $this->getMax()
        ];
    }

    public function jsonSerialize()
    {
        return $this->getInterval();
    }
}
