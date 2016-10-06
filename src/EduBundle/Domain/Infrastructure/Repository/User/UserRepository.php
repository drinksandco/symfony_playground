<?php

namespace EduBundle\Domain\Infrastructure\Repository\User;

use EduBundle\Domain\Model\User\User;
use EduBundle\Domain\Model\User\UserId;

interface UserRepository
{
    /** @return User */
    public function find(UserId $a_user_id);

    /** @return User[] */
    public function findAll();

    public function persist(User $a_user);

    public function remove(UserId $a_user_id);

    public function flush();
}
