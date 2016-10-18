<?php

namespace Workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use UserManager\Application\Service\User\Add\AddUserRequest;
use UserManager\Application\Service\User\Delete\DeleteUserRequest;
use UserManager\Application\Service\User\Update\UpdateUserRequest;
use UserManager\ReadModel\Application\Service\User\GetAll\GetAllUsersRequest;
use UserManager\ReadModel\Application\Service\User\GetById\GetByIdRequest;
use Workshop\UserBundle\Form\UserType;

class UserController extends Controller
{
    public function listAction()
    {
        $users = $this->get('user_manager.read_model.application.service.user.get_all')->__invoke(
            new GetAllUsersRequest()
        );

        return $this->render('UserBundle:User:list.html.twig', [
            'users' => $users
        ]);
    }

    public function viewAction($user_id)
    {
        $user = $this->get('user_manager.read_model.application.service.user.get_by_id')->__invoke(
            new GetByIdRequest($user_id)
        );

        return $this->render('UserBundle:User:view.html.twig', [
            'user' => $user
        ]);
    }

    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $this->get('user_manager.application.service.user.add')->__invoke(
                new AddUserRequest(
                    $form->get('name')->getData(),
                    $form->get('surname')->getData(),
                    $form->get('email')->getData(),
                    $form->get('username')->getData()
                )
            );

            $this->addFlash('success', 'User registered successfully');

            return $this->redirectToRoute('user_list');
        }

        return $this->render('UserBundle:User:register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function updateAction($user_id, Request $request)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $this->get('user_manager.application.service.user.update')->__invoke(
                new UpdateUserRequest(
                    $user_id,
                    $form->get('name')->getData(),
                    $form->get('surname')->getData(),
                    $form->get('email')->getData()
                )
            );

            $this->addFlash('success', 'User updated successfully');

            return $this->redirectToRoute('user_list');
        }

        $user = $this->get('user_manager.read_model.application.service.user.get_by_id')->__invoke(
            new GetByIdRequest($user_id)
        );

        return $this->render('UserBundle:User:update.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    public function deleteAction($user_id)
    {
        $this->get('user_manager.application.service.user.delete')->__invoke(new DeleteUserRequest($user_id));

        $this->addFlash('success', 'User removed successfully');

        return $this->redirectToRoute('user_list');
    }
}
