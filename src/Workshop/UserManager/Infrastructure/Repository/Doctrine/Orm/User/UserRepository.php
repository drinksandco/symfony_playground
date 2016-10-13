<?php

namespace UserManager\Infrastructure\Repository\Doctrine\Orm\User;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\Skill;
use UserManager\Domain\Model\User\SkillCollection;
use UserManager\Domain\Model\User\SkillId;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\UserCollection;
use UserManager\Domain\Model\User\UserId;
use UserManager\Domain\Model\User\Username;
use Workshop\UserBundle\Entity\DoctrineSkill;
use Workshop\UserBundle\Entity\DoctrineUser;

class UserRepository implements UserRepositoryContract
{
    /** @var EntityManagerInterface */
    private $entity_manager;

    public function __construct(EntityManagerInterface $an_entity_manager)
    {
        $this->entity_manager = $an_entity_manager;
    }

    public function findAll()
    {
        $result = $this->entity_manager->getRepository(DoctrineUser::class)->findAll();

        if (empty($result))
        {
            return new UserCollection();
        }

        return $this->hydrateUsers($result);
    }

    public function findById(UserId $user_id)
    {
        $result = $this->entity_manager->getRepository(DoctrineUser::class)->find($user_id->userId());

        if (empty($result))
        {
            return null;
        }

        return $this->hydrateUser($result);
    }

    public function add(User $a_new_user)
    {
        $a_doctrine_user = $this->hydrateDoctrineUser($a_new_user, $is_an_insert = true);
        $this->entity_manager->persist($a_doctrine_user);
        $this->entity_manager->flush();
    }

    public function update(User $a_user)
    {
        $a_doctrine_user = $this->hydrateDoctrineUser($a_user, $is_an_insert = false);
        $this->entity_manager->persist($a_doctrine_user);
        $this->entity_manager->flush();
    }

    public function delete(UserId $user_id)
    {
        $doctrine_user = $this->entity_manager->getReference(DoctrineUser::class, $user_id->userId());

        $this->entity_manager->remove($doctrine_user);
        $this->entity_manager->flush();
    }

    private function hydrateUsers($result)
    {
        $user_collection = new UserCollection();

        foreach ($result as $doctrine_user)
        {
            $user = $this->hydrateUser($doctrine_user);

            $user_collection->add($user);
        }

        return $user_collection;
    }

    private function hydrateUser(DoctrineUser $doctrine_user)
    {
        return new User(
            new UserId($doctrine_user->userId()),
            $doctrine_user->name(),
            $doctrine_user->surname(),
            new Username($doctrine_user->username()),
            new Email($doctrine_user->email()),
            $this->hydrateSkillsCollection($doctrine_user->skills())
        );
    }

    private function hydrateDoctrineUser(User $user, $is_an_insert = true)
    {
        $skills = $user->skills();

        if (!$is_an_insert)
        {
            /** @var DoctrineUser $doctrine_user */
            $doctrine_user = $this->entity_manager->getReference(DoctrineUser::class, $user->userId()->userId());
            $doctrine_user
                ->setName($user->name())
                ->setSurname($user->surname())
                ->setUsername($user->username()->username())
                ->setEmail($user->email()->email());
        }
        else
        {
            $doctrine_user = new DoctrineUser(
                $user->userId()->userId(),
                $user->name(),
                $user->surname(),
                $user->username()->username(),
                $user->email()->email()
            );
        }


        if (!$skills->isEmpty())
        {
            /** @var Skill $skill */
            foreach ($skills as $skill)
            {
                /** @var DoctrineSkill $doctrine_skill */
                $doctrine_skill = $this->entity_manager->getReference(DoctrineSkill::class, $skill->skillId()->skillId());
                $doctrine_skill
                    ->setName($skill->name())
                    ->setType($skill->type())
                    ->setUser($doctrine_user);

                $doctrine_user->addSkill($doctrine_skill);
            }
        }

        return $doctrine_user;
    }

    private function hydrateSkillsCollection(Collection $doctrine_skills)
    {
        $skills_collection = new SkillCollection();

        /** @var DoctrineSkill $doctrine_skill */
        foreach ($doctrine_skills as $doctrine_skill)
        {
            $skill = new Skill(
                new SkillId($doctrine_skill->skillId()),
                $doctrine_skill->name(),
                $doctrine_skill->type()
            );

            $skills_collection->add($skill);
        }

        return $skills_collection;
    }
}
