<?php

namespace App\Domain\User\Gender;


interface GenderInterface
{
    public function __construct(String $gender);

    public function getGender();

    public function getOpposite();

    public function __toString();
}
