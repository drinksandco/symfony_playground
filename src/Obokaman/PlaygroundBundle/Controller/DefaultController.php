<?php

namespace Obokaman\PlaygroundBundle\Controller;

use Obokaman\Playground\Application\Service\User\AddUser;
use Obokaman\Playground\Application\Service\User\AddUserCommand;
use Obokaman\Playground\Application\Service\User\EditUserCommand;
use Obokaman\Playground\Application\Service\User\RemoveUserCommand;
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

        $add_user_command = new AddUserCommand(
            'Pepote ' . rand(1, 10000),
            'pepote.' . rand(1, 10000) . '@gmail.com',
            $skills
        );

        $this->get('obokaman.domain.command_bus')->handle($add_user_command);

        return $this->redirectToRoute('obo_homepage');
    }

    public function removeAction($user_id)
    {
        $remove_user_command = new RemoveUserCommand($user_id);
        $this->get('obokaman.domain.command_bus')->handle($remove_user_command);

        return $this->redirectToRoute('obo_homepage');
    }

    public function editAction($user_id, $name, $email)
    {
        $edit_user_command = new EditUserCommand($user_id, $name, $email);
        $this->get('obokaman.domain.command_bus')->handle($edit_user_command);

        return $this->redirectToRoute('obo_homepage');
    }
}
