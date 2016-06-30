<?php

namespace UsersManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UsersManagementBundle:Default:index.html.twig');
    }
}
