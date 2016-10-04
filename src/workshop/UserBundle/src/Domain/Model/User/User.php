<?php

namespace Workshop\UserBundle\Controller;

class User
{
    /** @var integer */
    private $user_id;

    /** @var String */
    private $email;

    /** @var string */
    private $name;

    public function __construct($a_user_id, $an_email, $a_name)
    {
        $this->user_id = $a_user_id;
        $this->email   = $an_email;
        $this->name    = $a_name;
    }

    public function id()
    {
        return $this->user_id;
    }

    public function email()
    {
        return $this->email;
    }

    public function name()
    {
        return $this->name;
    }
}
