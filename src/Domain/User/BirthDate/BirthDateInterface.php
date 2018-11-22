<?php

namespace App\Domain\User\BirthDate;


interface BirthDateInterface
{
    public static function createFromAge(Int $age);

    public function __construct(String $date);

    public function getDate();

    public function __toString();
}
