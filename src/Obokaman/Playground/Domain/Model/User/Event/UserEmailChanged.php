<?php

namespace Obokaman\Playground\Domain\Model\User\Event;

use Obokaman\Playground\Domain\Kernel\DomainEvent;

final class UserEmailChanged extends DomainEvent
{
    const EVENT_KEY = 'obokaman.user.changed.email';

    /** @var string */
    private $user_id;

    /** @var string */
    private $email;

    public function __construct(string $a_user_id, string $an_email)
    {
        parent::__construct();
        $this->user_id = $a_user_id;
        $this->email   = $an_email;
    }
}
