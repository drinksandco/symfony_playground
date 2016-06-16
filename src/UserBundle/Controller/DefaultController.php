<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function getUsersAction()
    {
        $repo = $this->get('user_bundle.user_persistence');
        $results = $repo->getAllUsers();

        return $this->render('base.html.twig', [
            'results' => $results
        ]);
    }
}
