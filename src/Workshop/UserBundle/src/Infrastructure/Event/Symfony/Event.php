<?php

namespace Workshop\UserBundle\src\Infrastructure\Event\Symfony;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use Workshop\UserBundle\src\Domain\Event\DomainEvent;

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
}
