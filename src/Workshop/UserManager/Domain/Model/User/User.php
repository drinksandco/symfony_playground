<?php

namespace UserManager\Domain\Model\User;

use UserManager\Domain\Infrastructure\Event\User\UserAdded;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\ValueObject\UserId;
use UserManager\Domain\Infrastructure\Event\DomainEventRecorder;
use UserManager\Domain\Model\User\ValueObject\Username;

final class User
{
    /** @var UserId */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $surname;

    /** @var Username */
    private $username;

    /** @var Email */
    private $email;

    private function __construct(UserId $a_user_id, $a_name, $a_surname, $a_username, Email $an_email)
    {
        $this->user_id = $a_user_id;
        $this->name = $a_name;
        $this->surname = $a_surname;
        $this->username = $a_username;
        $this->email = $an_email;
    }

    public static function register($a_name, $a_surname, Username $a_username, Email $an_email)
    {
        $new_user_id = UserId::generate();
        $new_user = new self($new_user_id, $a_name, $a_surname, $a_username, $an_email);

        DomainEventRecorder::getInstance()->recordEvent(new UserAdded($new_user));

        return $new_user;
    }

    public static function fromExistent(UserId $a_user_id, $a_name, $a_surname, $a_username, Email $an_email)
    {
        return new self($a_user_id, $a_name, $a_surname, $a_username, $an_email);
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
}
