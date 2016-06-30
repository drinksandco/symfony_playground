<?php

namespace Workshop\UserBundle\src\Infrastructure\Event\Symfony;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use Workshop\UserBundle\src\Domain\Event\DomainEvent;

class Event extends SymfonyEvent
{
    const NAME = 'event.test';
    
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
