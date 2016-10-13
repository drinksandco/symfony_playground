<?php

namespace UserManager\Domain\Infrastructure\EventDispatcher;

use UserManager\Domain\Infrastructure\Event\DomainEvent;

interface DomainEventDispatcher
{
    public function dispatch(DomainEvent $an_event);
}
