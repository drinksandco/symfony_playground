<?php

namespace Playground\App\Domain\Model\User\Event;

use Playground\App\Domain\Kernel\DomainEvent;

final class UserRemoved extends DomainEvent
{
    const EVENT_KEY = 'playground.user.removed';

    /** @var string */
    private $user_id;

    public function __construct(string $a_user_id)
    {
        parent::__construct();
        $this->user_id = $a_user_id;
    }

    public function userId()
    {
        return $this->user_id;
    }
}
