<?php

namespace Obokaman\Playground\Domain\Model\User\Event;

use Obokaman\Playground\Domain\Kernel\DomainEvent;

final class UserCreated extends DomainEvent
{
    const EVENT_KEY = 'obokaman.user.created';

    /** @var string */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    public function __construct(string $a_user_id, string $a_name, string $an_email)
    {
        parent::__construct();
        $this->user_id     = $a_user_id;
        $this->name        = $a_name;
        $this->email       = $an_email;
    }
}
