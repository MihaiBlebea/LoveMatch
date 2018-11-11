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
            'payload'    => $this->serialize($event),
            'occured_on' => $event->ocurredOn()->format('Y-m-d H:i:s')
        ]);
    }

    public function getSince()
    {
        // Get event that happened after a timestamp
    }

    private function serialize(DomainEventInterface $event)
    {
        $object = [
            'name'       => get_class($event),
            'body'       => $event->getBody(),
            'occured_on' => $event->ocurredOn()->format('Y-m-d H:i:s')
        ];
        return json_encode($object);
    }

    private function deserialize()
    {
        //
    }
}