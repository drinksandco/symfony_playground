<?php

namespace UserManager\Infrastructure\EventSubscriber\Symfony;

use UserManager\Domain\Infrastructure\Event\DomainEvent;
use UserManager\Domain\Infrastructure\EventSubscriber\DomainEventSubscriber;

class EventSubscriber
{
    /** @var DomainEventSubscriber */
    private $event_subscriber;
    
    public function __construct(DomainEventSubscriber $an_event_subscriber)
    {
        $this->event_subscriber = $an_event_subscriber;
    }

    public function __invoke(DomainEvent $an_event)
    {
        
    }

    public function on()
    {
        
    }
}
