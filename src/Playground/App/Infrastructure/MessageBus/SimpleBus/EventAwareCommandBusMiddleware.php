<?php

namespace Playground\App\Infrastructure\MessageBus\SimpleBus;

use Playground\App\Domain\Kernel\EventDispatcher;
use Playground\App\Domain\Kernel\EventRecorder;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

final class EventAwareCommandBusMiddleware implements MessageBusMiddleware
{
    /** @var EventDispatcher */
    private $event_dispatcher;

    public function __construct(EventDispatcher $an_event_dispatcher)
    {
        $this->event_dispatcher = $an_event_dispatcher;
    }

    public function handle($message, callable $next_middleware)
    {
        $this->clearEvents();

        $next_middleware($message);

        $events = EventRecorder::instance()->getEvents();

        $this->dispatchEvents($events);
    }

    private function dispatchEvents($events)
    {
        foreach ($events as $event)
        {
            $this->event_dispatcher->dispatch($event);
        }
    }

    private function clearEvents()
    {
        EventRecorder::instance()->clearEvents();
    }
}
