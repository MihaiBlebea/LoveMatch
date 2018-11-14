<?php

namespace App\Application\Match;


interface NewMatchRequestInterface
{
    public function __construct(String $like_a_id, String $like_b_id);

    public function getFirstLikeId();

    public function getSecondLikeId();
}
