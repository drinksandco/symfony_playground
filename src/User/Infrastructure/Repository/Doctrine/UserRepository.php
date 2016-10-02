<?php

namespace User\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use User\Domain\UserId;
use User\Domain\UserRepository as UserRepositoryInterface;

final class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function findById(UserId $a_user_id)
    {
        $user_id = (string)$a_user_id;

        return parent::find($user_id);
    }
}
