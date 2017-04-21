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

        // cache for 10 seconds
        $response->setSharedMaxAge(10);

        // (optional) set a custom Cache-Control directive
        $response->headers->addCacheControlDirective('must-revalidate', true);

        $app_service = $this->get('playground.application.service.user.list');
        $users_list  = $app_service->__invoke();

        $hash_content = serialize($users_list);
        $response->setEtag(md5($hash_content));

        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list], $response);
    }
}
