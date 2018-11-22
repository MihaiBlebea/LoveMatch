<?php

namespace App\Domain\User\Location;

use JsonSerializable;


class Location implements LocationInterface, JsonSerializable
{
    private $long;

    private $lat;

    private $r = 6371;


    public function __construct(String $long, String $lat)
    {
        if(!$this->assertLongitudeIsValid($long))
        {
            throw new \Exception('Longitude is not valid', 1);
        }

        if(!$this->assertLatitudeIsValid($lat))
        {
            throw new \Exception('Latitude is not valid', 1);
        }

        $this->long = $long;
        $this->lat  = $lat;
    }

    private function assertLongitudeIsValid(String $long)
    {
        return -180 < (int) $long && (int) $long < 180;
    }

    private function assertLatitudeIsValid(String $lat)
    {
        return -90 < (int) $lat && (int) $lat < 90;
    }

    public function distance(LocationInterface $location, String $unit = 'K')
    {
        $long = $location->getLongitude();
        $lat  = $location->getLatitude();

        if(($this->lat === $lat) && ($this->long === $long))
        {
            return 0;
        } else {
            $theta = $this->long - $long;
            $dist = sin(deg2rad($this->lat)) * sin(deg2rad($lat)) +  cos(deg2rad($this->lat)) * cos(deg2rad($lat)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if($unit === 'K')
            {
                return ($miles * 1.609344);
            } else if ($unit === 'N') {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function getMaxLatitude(Int $distance)
    {
        return $this->lat + rad2deg($distance/$this->r);
    }

    public function getMinLatitude(Int $distance)
    {
        return $this->lat - rad2deg($distance/$this->r);
    }

    public function getMaxLongitude(Int $distance)
    {
        return $this->long + rad2deg(asin($distance/$this->r) / cos(deg2rad($this->lat)));
    }

    public function getMinLongitude(Int $distance)
    {
        return $this->long - rad2deg(asin($distance/$this->r) / cos(deg2rad($this->lat)));
    }

    public function getLongitude()
    {
        return $this->long;
    }

    public function getLatitude()
    {
        return $this->lat;
    }

    public function getLocation()
    {
        return [
            'longitude' => $this->getLongitude(),
            'latitude'  => $this->getLatitude()
        ];
    }

    public function jsonSerialize()
    {
        return $this->getLocation();
    }
}
