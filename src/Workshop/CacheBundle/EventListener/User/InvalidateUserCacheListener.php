<?php

namespace Workshop\CacheBundle\EventListener\User;

use Workshop\UserBundle\src\Domain\Event\DomainEvent;
use Workshop\UserBundle\src\Domain\EventSubscriber\DomainEventSubscriber;

class InvalidateUserCacheListener implements DomainEventSubscriber
{
    public function __invoke(DomainEvent $an_event)
    {
        // TODO: Implement __invoke() method.
    }
}
