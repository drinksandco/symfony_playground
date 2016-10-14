<?php

namespace Obokaman\Playground\Infrastructure\MessageBus\Symfony;

use Obokaman\Playground\Domain\Kernel\DomainEvent;
use Obokaman\Playground\Domain\Kernel\EventDispatcher as EventDispatcherContract;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class EventDispatcher implements EventDispatcherContract
{
    /** @var EventDispatcherInterface */
    private $event_dispatcher;

    public function __construct(EventDispatcherInterface $an_event_dispatcher)
    {
        $this->event_dispatcher = $an_event_dispatcher;
    }

    public function dispatch(DomainEvent $an_event)
    {
        $symfony_event = new SymfonyEvent($an_event);

        $this->event_dispatcher->dispatch($an_event::EVENT_KEY, $symfony_event);
    }
}
