<?php

namespace Obokaman\PlaygroundBundle\Controller;

use Obokaman\Playground\Application\Service\User\EditUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $app_service = $this->get('obokaman.application.service.user.list');

        $users = $app_service->__invoke();

        return $this->render('PlaygroundBundle:Default:index.html.twig',[
            'users' => $users
        ]);
    }

    public function addAction()
    {
        $app_service = $this->get('obokaman.application.service.user.add');
        $app_service->__invoke();

        return $this->redirectToRoute('obo_homepage');
    }

    public function removeAction($user_id)
    {
        $app_service = $this->get('obokaman.application.service.user.remove');
        $app_service->__invoke($user_id);

        return $this->redirectToRoute('obo_homepage');
    }

    public function editAction($user_id, $name, $email)
    {
        $app_service = $this->get('obokaman.application.service.user.edit');

        $request = new EditUserRequest($user_id, $name, $email);
        $app_service->__invoke($request);

        return $this->redirectToRoute('obo_homepage');
    }
}
