<?php

namespace App\Infrastructure\Event;

use App\Domain\User\DomainEventInterface;
use Ramsey\Uuid\Uuid;


class EventStore
{
    private $events = [];

    private $persist;


    public function __construct($persist)
    {
        $this->persist = $persist;
    }

    public function nextId()
    {
        return strtoupper(Uuid::uuid4());
    }

    public function add(DomainEventInterface $event)
    {
        $this->persist->table('events')->create([
            'id'         => $this->nextId(),
            'payload'    => json_encode($event),
            'occured_on' => $event->ocurredOn()->format('Y-m-d H:i:s')
        ]);
    }

    public function getSince()
    {
        // Get event that happened after a timestamp
    }

    private function deserialize()
    {
        //
    }
}
