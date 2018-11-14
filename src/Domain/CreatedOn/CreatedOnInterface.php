<?php

namespace App\Domain\CreatedOn;


interface CreatedOnInterface
{
    public function __construct(String $date = null);

    public function getDate();

    public function getDateTime();

    public function __toString();
}
