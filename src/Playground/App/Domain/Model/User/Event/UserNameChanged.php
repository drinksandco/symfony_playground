<?php

namespace Playground\App\Domain\Model\User\Event;

use Playground\App\Domain\Kernel\DomainEvent;

final class UserNameChanged extends DomainEvent
{
    const EVENT_KEY = 'playground.user.changed.name';

    /** @var string */
    private $user_id;

    /** @var string */
    private $name;

    public function __construct(string $a_user_id, string $a_name)
    {
        parent::__construct();
        $this->user_id = $a_user_id;
        $this->name    = $a_name;
    }

    public function userId()
    {
        return $this->user_id;
    }
}
