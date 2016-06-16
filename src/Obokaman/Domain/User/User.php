<?php

namespace Obokaman\Domain\User;

class User
{
    /** @var UserId */
    private $user_id;

    /** @var string */
    private $name;

    /** @var Email */
    private $email;

    public function __construct(UserId $a_user_id, $a_name, Email $an_email)
    {
        $this->user_id = $a_user_id;
        $this->name    = $a_name;
        $this->email   = $an_email;
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function changeName($a_name)
    {
        $this->name = $a_name;
    }

    public function changeEmail(Email $an_email)
    {
        $this->email = $an_email;
    }
}
