<?php

namespace Obokaman\Playground\Domain\Kernel;

interface EventDispatcher
{
    public function dispatch(DomainEvent $an_event);
}
