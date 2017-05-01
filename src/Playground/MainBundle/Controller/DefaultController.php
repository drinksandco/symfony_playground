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

        $last_user_modified = $this->get('playground.repository.user')->findLastModified();

        if (!empty($last_user_modified))
        {
            $last_modified = new \DateTime();
            $last_modified->setTimestamp($last_user_modified->updateDate()->getTimestamp());
            $response->setLastModified($last_modified);
        }

        if ($response->isNotModified($request))
        {
            return $response;
        }

        $app_service = $this->get('playground.application.service.user.list');
        $users_list  = $app_service->__invoke();

        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list], $response);
    }
}
