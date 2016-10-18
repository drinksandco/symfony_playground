<?php

namespace UserManager\Domain\Infrastructure\Repository\User;

use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\UserId;

interface UserRepository
{
    public function findAll();

    public function findById(UserId $user_id);

    public function persist(User $a_user, $needs_persist = false);

    public function delete(UserId $user_id);
}
