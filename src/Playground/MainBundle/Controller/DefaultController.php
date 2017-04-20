<?php

namespace Playground\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $response = new Response();
        $response->setPrivate();
        $response->setExpires(new \DateTime('tomorrow'));

        $app_service = $this->get('playground.application.service.user.list');
        $users_list  = $app_service->__invoke();

        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list], $response);
    }
}
