<?php

namespace App\Domain;

use DateTime;
use DateInterval;


class CalculateYearFromAgeService
{
    private $date;


    public static function execute($age)
    {
        $now = new DateTime();
        return $now->sub(new DateInterval('P' . $age . 'Y'))->format('Y-m-d');
    }

}
