<?php

namespace App\Domain;


interface DomainEventSubscriberInterface
{
    public function handle($event);

    public function isSubscribedTo($event);
}
