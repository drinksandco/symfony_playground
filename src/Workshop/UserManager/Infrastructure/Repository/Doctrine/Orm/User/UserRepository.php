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

    public function __construct(EntityManagerInterface $an_entity_manager)
    {
        $this->entity_manager = $an_entity_manager;
    }

    public function findAll()
    {
        $result = $this->entity_manager->getRepository(User::class)->findAll();

        if (empty($result))
        {
            return new UserCollection();
        }

        return $this->hydrateUsers($result);
    }

    public function findById(UserId $user_id)
    {
        $result = $this->entity_manager->getRepository(User::class)->find($user_id->userId());

        if (empty($result))
        {
            return null;
        }

        return $this->hydrateUser($result);
    }

    public function add(User $a_new_user)
    {
        $this->entity_manager->persist($a_new_user);
        $this->entity_manager->flush();
    }

    public function update(User $a_user)
    {
        $this->entity_manager->persist($a_user);
        $this->entity_manager->flush();
    }

    public function delete(UserId $user_id)
    {
        $user = $this->entity_manager->getReference(User::class, $user_id->userId());

        $this->entity_manager->remove($user);
        $this->entity_manager->flush();

        return true;
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

    private function hydrateUser(User $doctrine_user)
    {
        return new User(
            $doctrine_user->userId(), $doctrine_user->name(), $doctrine_user->surname(), $doctrine_user->username(), $doctrine_user->email(), $doctrine_user->skills()
        );
    }
}
