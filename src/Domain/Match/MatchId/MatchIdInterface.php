<?php

namespace App\Domain\Match\MatchId;


interface MatchIdInterface
{
    public function __construct($id);

    public function getId();

    public function __toString();
}
