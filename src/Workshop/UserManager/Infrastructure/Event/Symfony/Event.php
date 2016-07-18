<?php

namespace UserManager\Infrastructure\Event\Symfony;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use UserManager\Domain\Infrastructure\Event\DomainEvent;

class Event extends SymfonyEvent
{    
    /** @var DomainEvent */
    private $event;

    public function __construct(DomainEvent $an_event)
    {
        $this->event = $an_event;
    }

    public function event()
    {
        return $this->event;
    }

    public function name()
    {
        return $this->event->eventName();
    }
}
