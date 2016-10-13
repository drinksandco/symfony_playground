<?php

namespace UserManager\Infrastructure\EventDispatcher\Symfony;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UserManager\Domain\Infrastructure\Event\DomainEvent;
use UserManager\Domain\Infrastructure\EventDispatcher\DomainEventDispatcher;
use UserManager\Infrastructure\Event\Symfony\Event;

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

        $this->event_dispatcher->dispatch($symfony_event->name(), $symfony_event);
    }
}
