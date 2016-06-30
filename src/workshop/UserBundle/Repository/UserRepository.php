<?php

namespace workshop\UserBundle\Repository;


class UserRepository
{
    private $users = [
        ['name' => 'daniel'],
        ['name' => 'xavi'],
        ['name' => 'sandra'],
        ['name' => 'pablo'],
        ['name' => 'marcos'],
        ['name' => 'albert'],
        ['name' => 'eduard'],
    ];

    public function __construct()
    {
    }

    public function getAllUsers()
    {
        return $this->users;
    }

    public function signInUser(array $user)
    {
        return $this->users[] = $user;
    }

    public function deleteUser($user_name)
    {
        unset($this->users[$user_name]);

        return true;
    }
}
