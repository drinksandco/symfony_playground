<?php

namespace Obokaman\Playground\Domain\Model\User\Event;

use Obokaman\Playground\Domain\Kernel\DomainEvent;

final class UserCreated extends DomainEvent
{
    const EVENT_KEY = 'obokaman.user.created';

    /** @var string */
    private $user_id;

    public function __construct($a_user_id, \DateTimeImmutable $a_datetime)
    {
        $this->user_id     = $a_user_id;
        $this->occurred_on = $a_datetime;
    }

    public function userId()
    {
        return $this->user_id;
    }
}
