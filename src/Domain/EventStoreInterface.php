<?php

namespace App\Domain;


interface EventStoreInterface
{
    public function __construct($persist);

    public function nextId();

    public function add(DomainEventInterface $event);

    public function getSince();
}
