<?php

namespace Workshop\UserBundle\src\Domain\EventSubscriber;

use Workshop\UserBundle\src\Domain\Event\DomainEvent;

interface DomainEventSubscriber
{
    public function __invoke(DomainEvent $an_event);
}