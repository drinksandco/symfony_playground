<?php

namespace Workshop\UserBundle\src\Infrastructure\EventDispatcher\Symfony;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Workshop\UserBundle\src\Domain\Event\DomainEvent;
use Workshop\UserBundle\src\Domain\EventDispatcher\DomainEventDispatcher;

class EventDispatcher implements DomainEventDispatcher
{
    /** @var EventDispatcherInterface */
    private $event_dispatcher;

    public function __construct(EventDispatcherInterface $an_event_dispatcher)
    {
        $this->event_dispatcher = $an_event_dispatcher;
    }

    public function dispatch(DomainEvent $an_event)
    {
        $event_name = $an_event->eventName();
        
        new 

        $this->event_dispatcher->dispatch($event_name, $symfony_event);
    }
}
