<?php

namespace workshop\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use workshop\UserBundle\Controller as User;

class GetUsersService extends Controller
{
    /**
     * @var User\GetUsersService
     */
    private $get_users_use_case;

    public function __construct()
    {
        $this->get_users_use_case = new User\GetUsersService();
    }

    public function __invoke()
    {
        $cache = false;

        if (true == $cache)
        {
            return $users = ['name' => 'cache!'];
        }

        return $users = $this->get_users_use_case->__invoke();
    }
}
