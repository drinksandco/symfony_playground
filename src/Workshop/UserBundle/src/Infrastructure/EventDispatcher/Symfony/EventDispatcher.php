<?php

namespace Workshop\UserBundle\src\Infrastructure\EventDispatcher\Symfony;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Workshop\UserBundle\src\Domain\Event\DomainEvent;
use Workshop\UserBundle\src\Domain\EventDispatcher\DomainEventDispatcher;
use Workshop\UserBundle\src\Infrastructure\Event\Symfony\Event;

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
        $symfony_event = new Event($an_event);

        $this->event_dispatcher->dispatch(Event::NAME, $symfony_event);
    }
}
