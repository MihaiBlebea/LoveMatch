<?php

namespace App\Domain\User\Location;


interface LocationInterface
{
    public function __construct(String $long, String $lat);

    public function distance(LocationInterface $location, String $unit = 'K');

    public function getMaxLatitude(Int $distance);

    public function getMinLatitude(Int $distance);

    public function getMaxLongitude(Int $distance);

    public function getMinLongitude(Int $distance);

    public function getLongitude();

    public function getLatitude();

    public function getLocation();

    public function jsonSerialize();
}
