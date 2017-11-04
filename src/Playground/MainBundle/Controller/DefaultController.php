<?php

namespace Playground\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $app_service = $this->get('playground.application.service.user.list');
        $users_list  = $app_service->__invoke();

        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list]);
    }
}
