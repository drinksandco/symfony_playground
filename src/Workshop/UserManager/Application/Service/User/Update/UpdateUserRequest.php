<?php

namespace UserManager\Application\Service\User\Update;

final class UpdateUserRequest
{
    private $user_id;

    private $name;

    private $surname;

    private $email;

    public function __construct($user_id, $name, $surname, $email)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
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

    public function email()
    {
        return $this->email;
    }
}
