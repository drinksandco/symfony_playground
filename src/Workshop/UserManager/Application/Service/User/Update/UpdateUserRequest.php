<?php

namespace UserManager\Application\Service\User\Update;

final class UpdateUserRequest
{
    /** @var string */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $surname;

    /** @var string */
    private $email;

    /** @var array */
    private $skills;

    public function __construct($user_id, $name, $surname, $email, $skills = [])
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->skills = $skills;
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

    public function skills()
    {
        return $this->skills;
    }
}
