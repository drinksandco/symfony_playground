<?php

namespace workshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class GetUsersController extends Controller
{
    public function indexAction()
    {
		return $this->render('workshopUserBundle:Default:index.html.twig');
    }
}
