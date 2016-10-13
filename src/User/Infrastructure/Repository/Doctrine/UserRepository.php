<?php

namespace User\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;
use User\Domain\User;
use User\Domain\UserId;
use User\Domain\UserRepository as UserRepositoryInterface;

final class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function findById(UserId $a_user_id)
    {
        $user_id = (string) $a_user_id;

        return $this->find($user_id);
    }

    public function nextIdentity() : UserId
    {
        return UserId::fromString((string) Uuid::uuid4());
    }

    public function add(User $a_user, $flush = true)
    {
        $this->_em->persist($a_user);

        if($flush)
        {
            $this->_em->flush();
        }
    }
}
