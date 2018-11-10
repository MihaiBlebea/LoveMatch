<?php

namespace App\Infrastructure\Event;


interface DomainEventSubscriberInterface
{
    public function handle($event);

    public function isSubscribedTo($event);
}
