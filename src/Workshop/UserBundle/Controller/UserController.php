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

class UserController extends Controller
{
    public function listAction()
    {
        $users = $this->get('user_manager.read_model.application.service.user.get_all.use_case')->__invoke(
            new GetAllUsersRequest()
        );

        return $this->render('UserBundle:User:list.html.twig', [
            'users' => $users
        ]);
    }

    public function viewAction($user_id)
    {
        $user = $this->get('user_manager.read_model.application.service.user.get_by_id.use_case')->__invoke(
            new GetByIdRequest($user_id)
        );

        return $this->render('UserBundle:User:view.html.twig', [
            'user' => $user
        ]);
    }

    public function registerAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $this->get('user_manager.application.service.user.add.add_user')->__invoke(
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
        $user = $this->get('user_manager.read_model.application.service.user.get_by_id.use_case')->__invoke(
            new GetByIdRequest($user_id)
        );

        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $this->get('user_manager.application.service.user.update.update_user_use_case')->__invoke(
                new UpdateUserRequest(
                    $user_id,
                    $form->get('name')->getData(),
                    $form->get('surname')->getData(),
                    $form->get('email')->getData(),
                    $form->get('username')->getData()
                )
            );

            $this->addFlash('success', 'User updated successfully');

            return $this->redirectToRoute('user_list');
        }

        return $this->render('UserBundle:User:update.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    public function deleteAction($user_id)
    {
        $this->get('user_manager.application.service.user.delete.delete_user_use_case')->__invoke(new DeleteUserRequest($user_id));

        $this->addFlash('success', 'User removed successfully');

        return $this->redirectToRoute('user_list');
    }
}
