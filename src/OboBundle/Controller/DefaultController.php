<?php

namespace OboBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OboBundle:Default:index.html.twig');
    }
}
