<?php

namespace App\Domain;


interface DomainEventInterface
{
    public function getId();

    public function ocurredOn();
}
