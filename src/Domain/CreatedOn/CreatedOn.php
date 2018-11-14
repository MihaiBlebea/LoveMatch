<?php

namespace App\Domain\CreatedOn;

use DateTimeImmutable;


class CreatedOn implements CreatedOnInterface
{
    private $date_format = 'Y-m-d';

    private $date_time_format = 'Y-m-d H:i:s';

    private $date;


    public function __construct(String $date = null)
    {
        if($date === null)
        {
            $date = date($this->date_time_format);
        }

        if($this->assertDateFormat($date, $this->date_format))
        {
            $this->date = DateTimeImmutable::createFromFormat($this->date_format, $date);

        } elseif($this->assertDateFormat($date, $this->date_time_format)) {
            $this->date = DateTimeImmutable::createFromFormat($this->date_time_format, $date);

        } else {
            throw new \Exception('Date format is not accepted. Try ' . $this->date_format . ' or ' . $this->date_time_format, 1);
        }
    }

    private function assertDateFormat(String $date, String $format)
    {
        $new_date = DateTimeImmutable::createFromFormat($format, $date);
        return $new_date && $new_date->format($format) === $date;
    }

    public function getDate()
    {
        return $this->date->format($this->date_format);
    }

    public function getDateTime()
    {
        return $this->date->format($this->date_time_format);
    }

    public function __toString()
    {
        return $this->getDateTime();
    }
}
