<?php

namespace UserCacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserCacheBundle:Default:index.html.twig');
    }
}
