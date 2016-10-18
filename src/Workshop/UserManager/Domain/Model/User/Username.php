<?php

namespace UserManager\Domain\Model\User;

use UserManager\Domain\Model\User\Exception\InvalidUsernameException;

final class Username
{
    private $username;

    public function __construct($a_raw_username)
    {
        $this->setUsername($a_raw_username);
    }

    private function setUsername($raw_username)
    {
        if (!$this->isAlphanumeric($raw_username))
        {
            throw new InvalidUsernameException('Username is not alphanumeric');
        }

        $this->username = $raw_username;
    }

    private function isAlphanumeric($username)
    {
        return preg_match('/[a-z0-9]/', $username);
    }

    public function username()
    {
        return $this->username;
    }
}
