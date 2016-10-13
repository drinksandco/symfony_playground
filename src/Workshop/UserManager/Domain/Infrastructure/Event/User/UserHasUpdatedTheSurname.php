<?php

namespace UserManager\Domain\Infrastructure\Event\User;

use UserManager\Domain\Infrastructure\Event\DomainEvent;
use UserManager\Domain\Model\User\User;

class UserHasUpdatedTheSurname implements DomainEvent
{
    const NAME = 'domain.event.user.update.surname';

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

    public function __construct(User $a_user)
    {
        $this->user_id  = $a_user->userId()->userId();
        $this->name     = $a_user->name();
        $this->surname  = $a_user->surname();
        $this->username = $a_user->username()->username();
        $this->email    = $a_user->email()->email();
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

    public function eventName()
    {
        return self::NAME;
    }
}
