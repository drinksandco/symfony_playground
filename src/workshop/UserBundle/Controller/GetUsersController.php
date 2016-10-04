<?php

namespace Workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GetUsersController extends Controller
{
    public function indexAction()
    {
        $get_users_use_case = $this->get('workshop_user.controller.get_users_service');
        $users              = $get_users_use_case->__invoke();

        dump($users);

		return $this->render('workshopUserBundle:Default:index.html.twig');
    }
}
