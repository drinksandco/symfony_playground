<?php

namespace Obokaman\Domain\Service;

use Obokaman\Domain\Kernel\DomainEvent;

interface EventDispatcher
{
    public function dispatch(DomainEvent $an_event);
}
