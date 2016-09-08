<?php

namespace Obokaman\Playground\Domain\Kernel;

final class EventStore
{
    /** @var self */
    private static $instance;

    /** @var DomainEvent[] */
    private $events = [];

    public static function instance()
    {
        if (null === static::$instance)
        {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function storeEvent(DomainEvent $an_event)
    {
        array_push($this->events, $an_event);
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function clearEvents()
    {
        $this->events = [];
    }
}
