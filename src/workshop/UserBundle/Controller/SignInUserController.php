<?php

namespace workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use workshop\UserBundle\Repository\UserRepository;

class SignInUserController extends Controller
{
    public function indexAction()
    {
        $users_repo = new UserRepository();

        $users_repo->signInUser(['name' => 'javieer']);

        dump('javier added!');

        $users = $users_repo->getAllUsers();

        dump($users);

		return $this->render('workshopUserBundle:Default:index.html.twig');
    }
}
