<?php

namespace App\Domain\User\Description;


class Description implements DescriptionInterface
{
    private $description;

    private $max_length = 200;


    public function __construct(String $description)
    {
        if(!$this->assertMaxLength($description))
        {
            throw new \Exception('Description paragraph is too long. Max length is ' . $this->max_length . ' characters', 1);
        }

        $this->description = $description;
    }

    private function assertMaxLength(String $description)
    {
        return strlen($description) < $this->max_length;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function __toString()
    {
        return $this->getDescription();
    }
}
