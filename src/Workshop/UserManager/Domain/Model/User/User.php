<?php

namespace UserManager\Domain\Model\User;

use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\ValueObject\UserId;

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

    private function __construct(UserId $a_user_id, $a_name, $a_surname, $a_username, Email $an_email)
    {
        $this->user_id = $a_user_id;
        $this->name = $a_name;
        $this->surname = $a_surname;
        $this->username = $a_username;
        $this->email = $an_email;
    }

    public static function register($a_name, $a_surname, $a_username, Email $an_email)
    {
        $new_user_id = UserId::generate();
        return new self($new_user_id, $a_name, $a_surname, $a_username, $an_email);
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
