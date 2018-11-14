<?php

namespace App\Application\Match;


class NewMatchRequest implements NewMatchRequestInterface
{
    private $like_a_id;

    private $like_b_id;


    public function __construct(String $like_a_id, String $like_b_id)
    {
        $this->like_a_id = $like_a_id;
        $this->like_b_id = $like_b_id;
    }

    public function getFirstLikeId()
    {
        return $this->like_a_id;
    }

    public function getSecondLikeId()
    {
        return $this->like_b_id;
    }
}
