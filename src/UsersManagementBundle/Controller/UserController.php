<?php

namespace UsersManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UsersManagementBundle\Entity\User;
use UsersManagementBundle\Repository\UserRepository;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct()
    {
        $this->user_repository = $this->get('usersmanagementbundle.user_repository');
    }


    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $users = $this->user_repository->findAll();

        return $this->render(
            'user/index.html.twig',
            array(
                'users' => $users,
            )
        );
    }

    /**
     * Creates a new User entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('UsersManagementBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->user_repository->persist($user);
            $this->user_repository->flush();

            return $this->redirectToRoute('users_show', array('id' => $user->getId()));
        }

        return $this->render(
            'user/new.html.twig',
            array(
                'user' => $user,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render(
            'user/show.html.twig',
            array(
                'user'        => $user,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm   = $this->createForm('UsersManagementBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid())
        {
            $this->user_repository->persist($user);
            $this->user_repository->flush();

            return $this->redirectToRoute('users_edit', array('id' => $user->getId()));
        }

        return $this->render(
            'user/edit.html.twig',
            array(
                'user'        => $user,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->user_repository->remove($user);
            $this->user_repository->flush();
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()->setAction($this->generateUrl('users_delete', array('id' => $user->getId())))->setMethod('DELETE')->getForm();
    }
}
