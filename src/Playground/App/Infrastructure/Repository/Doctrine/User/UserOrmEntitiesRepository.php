<?php

namespace Playground\App\Infrastructure\Repository\Doctrine\User;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Playground\App\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use Playground\App\Domain\Kernel\EventRecorder;
use Playground\App\Domain\Model\Skill\Skill;
use Playground\App\Domain\Model\Skill\SkillCollection;
use Playground\App\Domain\Model\User\Event\UserRemoved;
use Playground\App\Domain\Model\User\User;
use Playground\App\Domain\Model\User\UserId;
use Playground\App\Domain\Model\User\UserNotFoundException;
use Playground\App\Infrastructure\Repository\Doctrine\_mapping\Skill\Skill as DoctrineSkill;
use Playground\App\Infrastructure\Repository\Doctrine\_mapping\User\User as DoctrineUser;

class UserOrmEntitiesRepository implements UserRepositoryContract
{
    private $em;
    private $repo;

    public function __construct(ManagerRegistry $a_manager_registry)
    {
        $this->em   = $a_manager_registry->getManagerForClass(DoctrineUser::class);
        $this->repo = $a_manager_registry->getRepository(DoctrineUser::class);
    }

    public function find(UserId $a_user_id)
    {
        $doctrine_user = $this->repo->find($a_user_id);

        if (empty($doctrine_user))
        {
            return null;
        }

        return $this->hydrateItem($doctrine_user);
    }

    public function findAll()
    {
        $doctrine_users = $this->repo->findAll();

        if (empty($doctrine_users))
        {
            return [];
        }

        return $this->hydrateItems($doctrine_users);
    }

    public function persist(User $a_user, $flush = true)
    {
        $doctrine_user = $this->repo->find($a_user->userId());

        if (empty($doctrine_user))
        {
            $doctrine_user = new DoctrineUser();
        }

        $this->updateDoctrineUser($doctrine_user, $a_user);

        $this->em->persist($doctrine_user);

        if (true === $flush)
        {
            $this->flush();
        }
    }

    public function remove(UserId $a_user_id, $flush = true)
    {
        $user = $this->repo->find($a_user_id);

        if (null === $user)
        {
            throw new UserNotFoundException($a_user_id);
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

    /**
     * @param DoctrineUser[] $doctrine_users
     *
     * @return User[]
     */
    private function hydrateItems(array $doctrine_users): array
    {
        $users = [];

        /** @var DoctrineUser $doctrine_user */
        foreach ($doctrine_users as $doctrine_user)
        {
            $users[] = $this->hydrateItem($doctrine_user);
        }

        return $users;
    }

    private function hydrateItem(DoctrineUser $doctrine_user): User
    {
        $skills = $this->hydrateSkills($doctrine_user->getSkills());

        $user = new User(
            $doctrine_user->getId(),
            $doctrine_user->getName(),
            $doctrine_user->getEmail(),
            \DateTimeImmutable::createFromMutable($doctrine_user->getCreationDate()),
            \DateTimeImmutable::createFromMutable($doctrine_user->getUpdateDate()),
            $skills
        );

        return $user;
    }

    private function hydrateSkills(Collection $doctrine_skills): SkillCollection
    {
        $skills = new SkillCollection();

        /** @var DoctrineSkill $doctrine_skill */
        foreach ($doctrine_skills as $doctrine_skill)
        {
            $skills->addItem(
                new Skill(
                    $doctrine_skill->getId(), $doctrine_skill->getDescription()
                )
            );
        }

        return $skills;
    }

    private function updateDoctrineUser(DoctrineUser $a_doctrine_user, User $a_user): DoctrineUser
    {
        $a_doctrine_user->setId($a_user->userId());
        $a_doctrine_user->setName($a_user->name());
        $a_doctrine_user->setEmail($a_user->email());
        $a_doctrine_user->setCreationDate((new \DateTime())->setTimestamp($a_user->creationDate()->getTimestamp()));
        $a_doctrine_user->setUpdateDate((new \DateTime())->setTimestamp($a_user->updateDate()->getTimestamp()));

        /** @var DoctrineSkill $skill */
        foreach ($a_doctrine_user->getSkills() as $doctrine_skill)
        {
            if (array_key_exists($doctrine_skill->getId()->id(), $a_user->skills()->items()))
            {
                continue;
            }

            $a_doctrine_user->removeSkill($doctrine_skill);
        }

        /** @var Skill $skill */
        foreach ($a_user->skills() as $skill)
        {
            $doctrine_skill = new DoctrineSkill();
            $doctrine_skill->setId($skill->skillId());
            $doctrine_skill->setDescription($skill->description());

            if ($this->hasDoctrineSkill($doctrine_skill, $a_doctrine_user->getSkills()))
            {
                continue;
            }

            $a_doctrine_user->addSkill($doctrine_skill);
        }

        return $a_doctrine_user;
    }

    private function hasDoctrineSkill(DoctrineSkill $target_doctrine_skill, Collection $doctrine_skills)
    {
        /** @var DoctrineSkill $doctrine_skill */
        foreach ($doctrine_skills as $doctrine_skill)
        {
            if ($doctrine_skill->getId() === $target_doctrine_skill->getId())
            {
                return true;
            }
        }
    }
}
