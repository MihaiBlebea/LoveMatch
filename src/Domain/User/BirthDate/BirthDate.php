<?php

namespace App\Domain\User\BirthDate;

use JsonSerializable;


class BirthDate implements BirthDateInterface, JsonSerializable
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

    public function getAge()
    {
        $now = new \DateTime();
        $age = $now->diff($this->date);
        return $age->y;
    }

    public function jsonSerialize()
    {
        return [
            'date'   => (string) $this,
            'format' => $this->format,
            'age'    => $this->getAge()
        ];
    }

    public function __toString()
    {
        return $this->getDate()->format($this->format);
    }
}
