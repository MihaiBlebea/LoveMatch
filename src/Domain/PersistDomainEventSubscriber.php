<?php

namespace App\Domain;


class PersistDomainEventSubscriber implements DomainEventSubscriberInterface
{
    private $event_store;


    public function __construct(EventStoreInterface $event_store)
    {
        $this->event_store = $event_store;
    }

    public function handle($event)
    {
        $this->event_store->add($event);
    }

    public function isSubscribedTo($event)
    {
        return true;
    }
}
