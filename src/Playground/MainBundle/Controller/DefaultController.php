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

        $app_service = $this->get('playground.application.service.user.list');
        $users_list  = $app_service->__invoke();

        // (optional) set a custom Cache-Control directive
        $response->headers->addCacheControlDirective('must-revalidate', true);

        // 1 - Public cache
        $response->setSharedMaxAge(10);

        // 2 - Etag cache
        $hash_content = serialize($users_list);
        $response->setEtag(md5($hash_content));

        // 3 - Last Modified cache
        //...

        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list], $response);
    }
}
