<?php

namespace Workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SignInUserController extends Controller
{
    public function indexAction()
    {
        $user = ['name' => 'javieer'];

        $add_users_use_case = $this->get('workshop_user.controller.add_user_service');
        $add_users_use_case->__invoke($user);

        dump('javier added!');

        $get_users_use_case = $this->get('workshop_user.controller.get_users_service');
        $users              = $get_users_use_case->__invoke();

        dump($users);

		return $this->render('workshopUserBundle:Default:index.html.twig');
    }
}
