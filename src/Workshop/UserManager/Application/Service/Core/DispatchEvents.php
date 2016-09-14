<?php

namespace UserManager\Application\Service\Core;

use UserManager\Domain\Infrastructure\EventDispatcher\DomainEventDispatcher;
use UserManager\Domain\Infrastructure\Event\DomainEventRecorder;

final class DispatchEvents
{
    /** @var ApplicationService */
    private $application_service;

    /** @var DomainEventDispatcher */
    private $domain_event_dispatcher;

    public function __construct(ApplicationService $an_application_service, DomainEventDispatcher $a_domain_event_dispatcher)
    {
        $this->application_service = $an_application_service;
        $this->domain_event_dispatcher = $a_domain_event_dispatcher;
    }

    public function __invoke()
    {
        $application_service_response = call_user_func_array([$this->application_service, '__invoke'], func_get_args());

        $this->dispatchApplicationServiceEvents();

        return $application_service_response;
    }

    public function dispatchApplicationServiceEvents()
    {
        $recorded_events = DomainEventRecorder::getInstance()->recordedEvents();
        DomainEventRecorder::getInstance()->eraseRecordedEvents();

        foreach ($recorded_events as $event)
        {
            $this->domain_event_dispatcher->dispatch($event);
        }
    }
}
