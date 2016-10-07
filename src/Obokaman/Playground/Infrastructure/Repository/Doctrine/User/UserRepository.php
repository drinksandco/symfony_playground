<?php

namespace Obokaman\Playground\Infrastructure\Repository\Doctrine\User;

use Doctrine\ORM\EntityManager;
use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use Obokaman\Playground\Domain\Kernel\EventRecorder;
use Obokaman\Playground\Domain\Model\User\Event\UserRemoved;
use Obokaman\Playground\Domain\Model\User\User;
use Obokaman\Playground\Domain\Model\User\UserId;
use Obokaman\Playground\Infrastructure\Repository\Doctrine\User\UserBaseRepository as DoctrineUserRepository;

class UserRepository implements UserRepositoryContract
{
    /** @var EntityManager */
    private $em;

    /** @var DoctrineUserRepository */
    private $repo;

    public function __construct(EntityManager $an_entity_manager)
    {
        $this->em   = $an_entity_manager;
        $this->repo = $this->em->getRepository("Playground:User\User");
    }

    public function find(UserId $a_user_id)
    {
        return $this->repo->find((string) $a_user_id);
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function persist(User $a_user, $flush = true)
    {
        $this->em->persist($a_user);

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
}
