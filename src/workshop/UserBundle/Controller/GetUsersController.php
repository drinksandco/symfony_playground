<?php

namespace workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GetUsersController extends Controller
{
    public function indexAction()
    {
        $users_repo = new GetUsersService();
        $users      = $users_repo->__invoke();

        dump($users);

		return $this->render('workshopUserBundle:Default:index.html.twig');
    }
}
