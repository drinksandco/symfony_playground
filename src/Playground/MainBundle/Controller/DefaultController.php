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

        $cache              = $this->get('cache.app');
        $last_modified_date = $cache->getItem('stats.user_lsat_modification');
        if ($last_modified_date->isHit())
        {
            $response->setLastModified($last_modified_date->get());
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
