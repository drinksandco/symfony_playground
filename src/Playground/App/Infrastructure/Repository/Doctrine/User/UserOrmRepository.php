<?php

namespace Playground\App\Infrastructure\Repository\Doctrine\User;

use Doctrine\ORM\EntityManager;
use Playground\App\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use Playground\App\Domain\Kernel\EventRecorder;
use Playground\App\Domain\Model\User\Event\UserRemoved;
use Playground\App\Domain\Model\User\User;
use Playground\App\Domain\Model\User\UserId;
use Playground\App\Domain\Model\User\UserNotFoundException;

class UserOrmRepository implements UserRepositoryContract
{
    private $em;

    private $repo;

    public function __construct(EntityManager $an_entity_manager)
    {
        $this->em   = $an_entity_manager;
        $this->repo = $this->em->getRepository(User::class);
    }

    public function find(UserId $a_user_id)
    {
        return $this->repo->find($a_user_id);
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
}
