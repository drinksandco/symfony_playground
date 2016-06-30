<?php

namespace workshop\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('workshopCacheBundle:Default:index.html.twig');
    }
}
