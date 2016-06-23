<?php

namespace Obokaman\Infrastructure\Event\Symfony;

use Obokaman\Domain\Kernel\DomainEvent;
use Symfony\Component\EventDispatcher\Event;

final class SymfonyEvent extends Event
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
