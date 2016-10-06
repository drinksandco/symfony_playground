<?php

namespace EduBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $application_service_to_use = $this->get('edu.application_service_user.list_users');
        $users                      = $application_service_to_use->__invoke();

        return $this->render(
            'EduBundle:Default:index.html.twig',
            [
                'users' => $users
            ]
        );
    }

    public function removeAction()
    {
        return $this->redirectToRoute('edu_homepage');
    }

    public function addAction()
    {
        $application_service_to_use = $this->get('edu.application_service_user.add_user');
        $application_service_to_use->__invoke();

        return $this->redirectToRoute('edu_homepage');
    }

    public function editAction()
    {
        return $this->redirectToRoute('edu_homepage');
    }

}
