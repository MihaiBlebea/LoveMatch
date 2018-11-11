<?php

namespace App\Domain\Pass\PassId;


interface PassIdInterface
{
    public function __construct($id);

    public function getId();

    public function __toString();
}
