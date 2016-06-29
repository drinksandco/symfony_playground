<?php

namespace Workshop\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CacheBundle:Default:index.html.twig');
    }
}
