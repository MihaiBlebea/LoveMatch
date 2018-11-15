<?php

namespace App\Domain\User\Gender;


class Gender implements GenderInterface
{
    private $gender;

    private $accepted = ['male', 'female', 'trans'];


    public function __construct(String $gender)
    {
        if(!$this->assertIsAccepted($gender))
        {
            throw new \Exception('Gender value is not in the accepted array', 1);
        }
        $this->gender = strtoupper($gender);
    }

    private function assertIsAccepted(String $gender)
    {
        return in_array(strtolower($gender), $this->accepted);
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function __toString()
    {
        return $this->getGender();
    }
}
