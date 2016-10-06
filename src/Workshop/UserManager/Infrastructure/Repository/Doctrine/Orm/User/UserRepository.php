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
        $result = $this->entity_manager->getRepository('UserManager:User\User')->findAll();

        $user_collection = new UserCollection();

        if (empty($result))
        {
            return $user_collection;
        }

        foreach ($result as $user)
        {
            dump($user->skills()->getValues());die; //TODO: Solve this due to currenty it returns a PersistentCollection Object.
            $user_collection->add($user);
        }

        dump($user_collection);die;

        return $user_collection;
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
