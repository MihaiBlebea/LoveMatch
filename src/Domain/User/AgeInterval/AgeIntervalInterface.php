<?php

namespace App\Domain\User\AgeInterval;


interface AgeIntervalInterface
{
    public function __construct(Int $min, Int $max);

    public function getMin();

    public function getMax();

    public function getInterval();

    public function jsonSerialize();
}
