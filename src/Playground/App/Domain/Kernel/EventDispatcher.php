<?php

namespace Playground\App\Domain\Kernel;

interface EventDispatcher
{
    public function dispatch(DomainEvent $an_event);
}
