<?php

namespace UserManager\Domain\Infrastructure\Event;

interface DomainEvent
{
    public function eventName();
}
