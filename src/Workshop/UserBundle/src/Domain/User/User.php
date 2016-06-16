<?php

namespace Workshop\UserBundle\src\Domain\User;

use Workshop\UserBundle\src\Domain\Email\Email;
use Workshop\UserBundle\src\Domain\User\ValueObject\UserId;

final class User
{
    /** @var UserId */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $surname;

    /** @var string */
    private $username;

    /** @var Email */
    private $email;

    public function __construct(UserId $a_user_id, $a_name, $a_surname, $a_username, Email $an_email)
    {
        $this->user_id = $a_user_id;
        $this->name = $a_name;
        $this->surname = $a_surname;
        $this->username = $a_username;
        $this->email = $an_email;
    }

    public static function register($a_name, $a_surname, $a_username, Email $an_email)
    {
        return new self(new UserId(null), $a_name, $a_surname, $a_username, $an_email);
    }
}
