<?php

namespace App\Domain\Action\Type;


class Type implements TypeInterface
{
    private $type;

    private $accepted = ['pass', 'like'];


    public static function pass()
    {
        return new self('pass');
    }

    public static function like()
    {
        return new self('like');
    }

    public function __construct(String $type)
    {
        if(!$this->assertTypeIsAccepted($type))
        {
            throw new \Exception('Type supplied is not in accepted array', 1);
        }
        $this->type = $type;
    }

    public function assertTypeIsAccepted(String $type)
    {
        return in_array(strtolower($type), $this->accepted);
    }

    public function getType()
    {
        return strtoupper($this->type);
    }

    public function __toString()
    {
        return $this->getType();
    }
}
