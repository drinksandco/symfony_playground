<?php

namespace Playground\MainBundle\Controller;

use Playground\App\Application\Service\User\AddUser;
use Playground\App\Application\Service\User\AddUserCommand;
use Playground\App\Application\Service\User\EditUserCommand;
use Playground\App\Application\Service\User\RemoveUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManageUserController extends Controller
{
    public function addAction()
    {
        $quantity = rand(1, 4);
        $skills   = [];
        for ($i = 0; $i < $quantity; $i++)
        {
            $skills[] = AddUser::RANDOM_SKILLS[rand(0, 4)];
        }

        $add_user_command = new AddUserCommand(
            'Pepote ' . rand(1, 10000), 'pepote.' . rand(1, 10000) . '@gmail.com', $skills
        );

        try
        {
            $this->get('playground.domain.command_bus')->handle($add_user_command);
        }
        catch (\Exception $e)
        {
            $this->addFlash('error', 'There was an error: ' . $e->getMessage());

            return $this->redirectToRoute('app_homepage');
        }

        $this->addFlash('success', 'Added new user with ID: ' . $add_user_command->userId());

        return $this->redirectToRoute('app_homepage');
    }

    public function removeAction($user_id)
    {
        $remove_user_command = new RemoveUserCommand($user_id);
        try
        {
            $this->get('playground.domain.command_bus')->handle($remove_user_command);
        }
        catch (\Exception $e)
        {
            $this->addFlash('error', 'There was an error: ' . $e->getMessage());

            return $this->redirectToRoute('app_homepage');
        }
        $this->addFlash('success', 'Removed user with ID: ' . $remove_user_command->userId());

        return $this->redirectToRoute('app_homepage');
    }

    public function editAction($user_id, $name, $email)
    {
        $edit_user_command = new EditUserCommand($user_id, $name, $email);

        try
        {
            $this->get('playground.domain.command_bus')->handle($edit_user_command);
        }
        catch (\Exception $e)
        {
            $this->addFlash('error', 'There was an error: ' . $e->getMessage());

            return $this->redirectToRoute('app_homepage');
        }

        $this->addFlash('success', 'Edited succesfully user with ID: ' . $edit_user_command->userId());

        return $this->redirectToRoute('app_homepage');
    }
}
