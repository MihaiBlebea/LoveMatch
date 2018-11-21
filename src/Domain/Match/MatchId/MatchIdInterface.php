<?php

namespace App\Domain\Match\MatchId;


interface MatchIdInterface
{
    public function __construct($id);

    public function getId();

    public function isEqual(MatchIdInterface $id);

    public function __toString();
}
