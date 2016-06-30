<?php

namespace Workshop\UserBundle\src\Domain\Event\User;

use Workshop\UserBundle\src\Domain\Event\DomainEvent;

class UserAdded implements DomainEvent
{
    const NAME = 'domain.event.user.added';
    
    /** @var string */
    private $user_id;

    public function __construct($a_raw_user_id)
    {
        $this->user_id = $a_raw_user_id;
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function eventName()
    {
        return self::NAME;
    }
}
