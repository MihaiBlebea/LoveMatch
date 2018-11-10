<?php

namespace App\Domain\User;


interface DomainEventInterface
{
    public function getId();

    public function getBody();
    
    public function ocurredOn();
}
