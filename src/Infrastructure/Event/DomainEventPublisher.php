<?php

namespace App\Infrastructure\Event;

use App\Domain\User\DomainEventInterface;


class DomainEventPublisher
{
    private $subscribers;

    private static $instance = null;


    public static function instance()
    {
        if(null === static::$instance)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }

    public function subscribe(DomainEventSubscriberInterface $subscriber)
    {
        $this->subscribers[] = $subscriber;
    }

    public function publish(DomainEventInterface $event)
    {
        foreach($this->subscribers as $subscriber)
        {
            if($subscriber->isSubscribedTo($event))
            {
                $subscriber->handle($event);
            }
        }
    }
}
