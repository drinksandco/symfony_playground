<?php

namespace Workshop\UserBundle\src\Infrastructure\EventSubscriber\Symfony;

use Workshop\UserBundle\src\Domain\Event\DomainEvent;
use Workshop\UserBundle\src\Domain\EventSubscriber\DomainEventSubscriber;

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