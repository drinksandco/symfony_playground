<?php

namespace OboBundle\Controller;

use Obokaman\Application\Service\User\AddUser;
use Obokaman\Application\Service\User\EditUser;
use Obokaman\Application\Service\User\EditUserRequest;
use Obokaman\Application\Service\User\ListUsers;
use Obokaman\Application\Service\User\RemoveUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /** @var ListUsers $app_service */
        $app_service = $this->get('obokaman.application.service.user.list');

        $users = $app_service->__invoke();

        return $this->render('OboBundle:Default:index.html.twig',[
            'users' => $users
        ]);
    }

    public function addAction()
    {
        /** @var AddUser $app_service */
        $app_service = $this->get('obokaman.application.service.user.add');
        $app_service->__invoke();

        return $this->redirectToRoute('obo_homepage');
    }

    public function removeAction($user_id)
    {
        /** @var RemoveUser $app_service */
        $app_service = $this->get('obokaman.application.service.user.remove');
        $app_service->__invoke($user_id);

        return $this->redirectToRoute('obo_homepage');
    }

    public function editAction($user_id, $name, $email)
    {
        /** @var EditUser $app_service */
        $app_service = $this->get('obokaman.application.service.user.edit');

        $request = new EditUserRequest($user_id, $name, $email);
        $app_service->__invoke($request);

        return $this->redirectToRoute('obo_homepage');
    }
}
