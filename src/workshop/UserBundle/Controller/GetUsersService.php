<?php

namespace workshop\UserBundle\Controller;

use workshop\UserBundle\Repository\UserRepository;

class GetUsersService
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        $users_repo = new UserRepository();
        $users = $users_repo->getAllUsers();

		return $users;
    }

}
