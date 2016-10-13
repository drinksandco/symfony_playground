<?php

namespace UserManager\Domain\Infrastructure\Event;

final class DomainEventRecorder
{
    /** @var DomainEventRecorder */
    private static $instance = null;

    /** @var DomainEvent[] */
    private $events;

    public static function instance()
    {
        if (null === static::$instance)
        {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function recordEvent(DomainEvent $a_new_domain_event)
    {
        $this->events[] = $a_new_domain_event;
    }

    public function recordedEvents()
    {
        return $this->events;
    }

    public function eraseRecordedEvents()
    {
        $this->events = [];
    }
}
