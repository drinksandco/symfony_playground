<?php

namespace Workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('workshopUserBundle:Default:index.html.twig');
    }
}
