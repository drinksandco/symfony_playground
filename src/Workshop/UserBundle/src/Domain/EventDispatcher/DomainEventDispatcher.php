<?php

namespace Workshop\UserBundle\src\Domain\EventDispatcher;

use Workshop\UserBundle\src\Domain\Event\DomainEvent;

interface DomainEventDispatcher
{
    public function dispatch(DomainEvent $an_event);
}
