<?php

namespace UserManager\Domain\Infrastructure\Event\User;

use UserManager\Domain\Infrastructure\Event\DomainEvent;
use UserManager\Domain\Model\User\User;

class UserHasAddedANewSkill implements DomainEvent
{
    const NAME = 'domain.event.user.add.skill';

   /** @var string */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $surname;

    /** @var string */
    private $username;

    /** @var string */
    private $email;

    /** @var array */
    private $skills;

    public function __construct(User $a_user)
    {
        $this->user_id  = $a_user->userId()->userId();
        $this->name     = $a_user->name();
        $this->surname  = $a_user->surname();
        $this->username = $a_user->username()->username();
        $this->email    = $a_user->email()->email();
        $this->skills = $a_user->skills()->toArray();
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function name()
    {
        return $this->name;
    }

    public function surname()
    {
        return $this->surname;
    }

    public function username()
    {
        return $this->username;
    }

    public function email()
    {
        return $this->email;
    }

    public function skills()
    {
        return $this->skills;
    }

    public function eventName()
    {
        return self::NAME;
    }
}
