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

        $users_repo = $this->get('playground.repository.user');
        $last_modified_date = $users_repo->getLastModifiedUserDate();

        $response->setLastModified($last_modified_date);
        if ($response->isNotModified($request))
        {
            return $response;
        }

        $app_service = $this->get('playground.application.service.user.list');
        $users_list  = $app_service->__invoke();

        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list], $response);
    }
}
