<?php

namespace Workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Workshop\UserBundle\src\Application\Service\User\Add\AddUserRequest;
use Workshop\UserBundle\src\Application\Service\User\GetAll\GetAllUsersRequest;

class UserController extends Controller
{
    public function listAction()
    {
        $users = $this->get('user_bundle.application.service.user.get_all.get_all_users_use_case')->__invoke(
            new GetAllUsersRequest()
        );
        
        return $this->render('UserBundle:User:list.html.twig', [
            'users' => $users 
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
            $this->get('user_bundle.application.service.user.add.add_user_use_case')->__invoke(
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
}
