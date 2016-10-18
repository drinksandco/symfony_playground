<?php

namespace UserManager\Infrastructure\Repository\Doctrine\Orm\User;

use Doctrine\ORM\EntityManagerInterface;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\UserCollection;
use UserManager\Domain\Model\User\UserId;

class UserRepository implements UserRepositoryContract
{
    /** @var EntityManagerInterface */
    private $entity_manager;
    private $repo;

    public function __construct(EntityManagerInterface $an_entity_manager)
    {
        $this->entity_manager = $an_entity_manager;
        $this->repo = $this->entity_manager->getRepository(User::class);
    }

    public function findAll()
    {
        $result = $this->repo->findAll();

        if (empty($result))
        {
            return new UserCollection();
        }

        return $this->hydrateUsers($result);
    }

    public function findById(UserId $user_id)
    {
        $result = $this->repo->find($user_id->userId());

        if (empty($result))
        {
            return null;
        }

        return $result;
    }

    public function persist(User $a_user, $needs_persist = false)
    {
        if ($needs_persist)
        {
            $this->entity_manager->persist($a_user);
        }

        $this->entity_manager->flush();
    }

    public function delete(UserId $user_id)
    {
        $user = $this->entity_manager->getReference(User::class, $user_id->userId());

        $this->entity_manager->remove($user);
        $this->entity_manager->flush();
    }

    private function hydrateUsers($result)
    {
        $user_collection = new UserCollection();

        foreach ($result as $user)
        {
            $user_collection->add($user);
        }

        return $user_collection;
    }
}
