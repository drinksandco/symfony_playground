<?php

namespace Obokaman\PlaygroundBundle\Controller;

use Obokaman\Playground\Application\Service\User\AddUser;
use Obokaman\Playground\Application\Service\User\AddUserRequest;
use Obokaman\Playground\Application\Service\User\EditUserRequest;
use Obokaman\Playground\Application\Service\User\RemoveUserRequest;
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
        $quantity = rand(1, 4);
        $skills   = [];
        for ($i = 0; $i < $quantity; $i++)
        {
            $skills[] = AddUser::RANDOM_SKILLS[rand(0, 4)];
        }

        $add_user_request = new AddUserRequest(
            'Pepote ' . rand(1, 10000),
            'pepote.' . rand(1, 10000) . '@gmail.com',
            $skills
        );

        $this->get('obokaman.application.service.user.add')->__invoke($add_user_request);

        return $this->redirectToRoute('obo_homepage');
    }

    public function removeAction($user_id)
    {
        $remove_user_request = new RemoveUserRequest($user_id);
        $this->get('obokaman.application.service.user.remove')->__invoke($remove_user_request);

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
