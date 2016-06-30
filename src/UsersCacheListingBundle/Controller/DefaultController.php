<?php

namespace UsersCacheListingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UsersCacheListingBundle:Default:index.html.twig');
    }
}
