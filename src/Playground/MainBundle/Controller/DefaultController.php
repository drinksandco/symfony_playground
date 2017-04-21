<?php

namespace Playground\MainBundle\Controller;

use DateTime;
use Playground\App\Domain\Model\User\User;
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
        $users_list = $app_service->__invoke();

        // (optional) set a custom Cache-Control directive
        $response->headers->addCacheControlDirective('must-revalidate', true);

        // 3 - Last Modified cache
        $date = $this->getLastUpdate($users_list);

        $response->setLastModified($date);
        $response->setPublic();

        if ($response->isNotModified($request)) {
            return $response;
        }


        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list], $response);
    }

    private function getLastUpdate($users_list)
    {
        $date = new DateTime('1979-02-07');

        /**
         * @var User[] $users_list
         */
        foreach ($users_list as $user)
        {
            $is_before = $date < $user->updateDate();

            if($is_before) $date = $user->updateDate();
        }

        return $date;
    }
}
