<?php

namespace App\Domain\User\BirthDate;


class BirthDate implements BirthDateInterface
{
    private $date;

    private $format = 'Y-m-d';


    public function __construct(String $date)
    {
        if(!$this->validateDate($date))
        {
            throw new \Exception('Date format is not correct. Please supply Y-m-d', 1);
        }
        $this->date = \DateTime::createFromFormat($this->format, $date);
    }

    public function getDate()
    {
        return $this->date;
    }

    private function validateDate(String $date)
    {
        $created_date = \DateTime::createFromFormat($this->format, $date);
        return $created_date && $created_date->format($this->format) === $date;
    }

    public function __toString()
    {
        return $this->getDate()->format('Y-m-d');
    }
}
