<?php

namespace UserManager\Infrastructure\Repository\Doctrine\Orm\User;

use Doctrine\ORM\EntityManagerInterface;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\ValueObject\UserId;

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
        return $this->entity_manager->getRepository('UserManager:User\User')->findAll();
    }

    public function findById(UserId $user_id)
    {
        return $this->entity_manager->getRepository('UserManager:User\User')->find($user_id->userId());
    }

    public function add(User $a_new_user)
    {
        $this->entity_manager->persist($a_new_user);
        $this->entity_manager->flush();
    }

    public function update(User $a_user)
    {
        $this->entity_manager->flush();
    }

    public function delete(UserId $user_id)
    {
        $user = $this->findById($user_id);

        if (!$user instanceof User)
        {
            return false;
        }

        $this->entity_manager->remove($user);
        $this->entity_manager->flush();

        return true;
    }

}
