<?php

namespace Playground\MainBundle\Controller;

use Playground\App\Domain\Model\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $response = new Response();

        $app_service = $this->get('playground.application.service.user.list');
        $users_list  = $app_service->__invoke();
        $last_date = null;
        /** @var User $user */
        foreach($users_list as $user)
        {
            $date = $user->updatedDate();
            if($last_date < $date || is_null($last_date))
            {
                $last_date = $date;
            }
        }
        $response->setLastModified($last_date);

        if($response->isNotModified($request))
        {
            return $response;
        }

        return $this->render('MainBundle:Default:index.html.twig', ['users' => $users_list], $response);
    }
}
