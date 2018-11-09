<?php

namespace App\Domain\User\BirthDate;


class BirthDate implements BirthDateInterface
{
    private $date;


    public function __construct(String $date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function __toString()
    {
        return $this->getDate();
    }
}
