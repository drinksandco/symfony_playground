<?php

namespace workshop\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GetUsersService extends Controller
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        $cache = true;

        if (true == $cache)
        {
            return $users = ['name' => 'cache!'];
        }

        $get_users_use_case = $this->get('workshop_user.controller.get_users_service');
        $users              = $get_users_use_case->__invoke();

		return $users;
    }
}
