<?php
namespace Obokaman\Application\Service\User;

class EditUserRequest
{
    public $user_id;
    public $name;
    public $email;

    public function __construct($a_user_id, $a_name, $an_email)
    {
        $this->user_id = $a_user_id;
        $this->name    = $a_name;
        $this->email   = $an_email;
    }
}
