<?php

namespace Obokaman\Playground\Infrastructure\Repository\Doctrine\User;

use Doctrine\ORM\EntityManager;
use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use Obokaman\Playground\Domain\Kernel\EventRecorder;
use Obokaman\Playground\Domain\Model\Skill\Skill;
use Obokaman\Playground\Domain\Model\Skill\SkillId;
use Obokaman\Playground\Domain\Model\User\Email;
use Obokaman\Playground\Domain\Model\User\Event\UserRemoved;
use Obokaman\Playground\Domain\Model\User\User;
use Obokaman\Playground\Domain\Model\User\UserId;
use Obokaman\PlaygroundBundle\Entity\Skill as DoctrineSkill;
use Obokaman\PlaygroundBundle\Entity\User as DoctrineUser;
use Obokaman\PlaygroundBundle\Repository\UserRepository as DoctrineUserRepository;

class UserRepository implements UserRepositoryContract
{
    /** @var EntityManager */
    private $em;

    /** @var DoctrineUserRepository */
    private $repo;

    public function __construct(EntityManager $an_entity_manager)
    {
        $this->em   = $an_entity_manager;
        $this->repo = $this->em->getRepository(DoctrineUser::class);
    }

    public function find(UserId $a_user_id)
    {
        $result = $this->repo->find((string) $a_user_id);

        return $this->hydrateItem($result);
    }

    public function findAll()
    {
        $results = $this->repo->findAll();

        return $this->hydrateItems($results);
    }

    public function persist(User $domain_user, $flush = true)
    {
        $doctrine_user = $this->repo->find((string) $domain_user->userId());

        if (null === $doctrine_user)
        {
            $doctrine_user = new DoctrineUser();
        }

        $doctrine_user->setUserId((string) $domain_user->userId());
        $doctrine_user->setEmail((string) $domain_user->email());
        $doctrine_user->setName($domain_user->name());
        $doctrine_user->setCreationDate(new \DateTime($domain_user->creationDate()->format('Y-m-d H:i:s')));

        foreach ($doctrine_user->getSkills() as $old_skill)
        {
            if (!$domain_user->hasSkill(new SkillId($old_skill->getSkillId())))
            {
                $doctrine_user->removeSkill($old_skill);
            }
        }

        foreach ($domain_user->skills() as $new_skill)
        {
            if ($doctrine_skill = $this->em->getRepository(DoctrineSkill::class)->find((string) $new_skill->skillId()))
            {
                continue;
            }

            $doctrine_skill = new DoctrineSkill();
            $doctrine_skill->setSkillId((string) $new_skill->skillId());
            $doctrine_skill->setDescription($new_skill->description());
            $doctrine_skill->setUser($doctrine_user);

            $doctrine_user->addSkill($doctrine_skill);
        }

        $this->em->persist($doctrine_user);

        if (true === $flush)
        {
            $this->flush();
        }
    }

    public function remove(UserId $a_user_id, $flush = true)
    {
        $user = $this->repo->find((string) $a_user_id);

        if (null === $user)
        {
            return;
        }

        $this->em->remove($user);

        if (true === $flush)
        {
            $this->flush();
        }

        EventRecorder::instance()->recordEvent(new UserRemoved($a_user_id));
    }

    public function flush()
    {
        $this->em->flush();
    }

    /** @return User[] */
    private function hydrateItems($results)
    {
        if (empty($results))
        {
            return [];
        }

        $users = [];
        foreach ($results as $result)
        {
            $user = $this->hydrateItem($result);
            array_push($users, $user);
        }

        return $users;
    }

    private function hydrateItem(DoctrineUser $result = null)
    {
        if (empty($result))
        {
            return null;
        }

        $creation_date = \DateTimeImmutable::createFromMutable($result->getCreationDate());

        $skill_array = [];
        $skills      = $result->getSkills();
        /** @var DoctrineSkill $skill */
        foreach ($skills as $skill)
        {
            $skill_array[$skill->getSkillId()] = new Skill(new SkillId($skill->getSkillId()), $skill->getDescription());
        }

        $user = new User(
            new UserId($result->getUserId()),
            $result->getName(),
            new Email($result->getEmail()),
            $creation_date,
            $skill_array
        );

        return $user;
    }
}
