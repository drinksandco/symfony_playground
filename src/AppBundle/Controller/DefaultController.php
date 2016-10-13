<?php

namespace AppBundle\Controller;

use Doctrine\DBAL\Types\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\Domain\Skill;
use User\Domain\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        Type::addType('skill', 'User\Infrastructure\Doctrine\types\SkillType');

        $em = $this->get('doctrine.orm.entity_manager');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('db_skill', 'skill');

        $user_repository = $em->getRepository('User\Domain\User');
        $skill_repository = $em->getRepository('User\Domain\Skill');

        $user_id = $user_repository->nextIdentity();
        $skill = new Skill($skill_repository->nextIdentity(), 'Be a Php Maista');
        $user = new User($user_id, "Marcos");
        $user->learnSkill($skill);
        $user_repository->add($user);
        $results = $user_repository->findById($user_id);


//        $results = [];
//        $repo            = $this->get('appbundle.test_repository');
//        $results         = $repo->getAllThings();

        return $this->render('base.html.twig',
            [
                'results' => $results
            ]
        );
    }
}
