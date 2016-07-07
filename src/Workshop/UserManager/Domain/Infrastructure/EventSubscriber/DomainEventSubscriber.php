<?php

namespace UserManager\Domain\Infrastructure\EventSubscriber;

use UserManager\Domain\Infrastructure\Event\DomainEvent;

interface DomainEventSubscriber
{
    public function __invoke(DomainEvent $an_event);
}
