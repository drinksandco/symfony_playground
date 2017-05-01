<?php

namespace Playground\App\Domain\Infrastructure\Repository\User;

use Playground\App\Domain\Model\User\User;
use Playground\App\Domain\Model\User\UserId;

interface UserRepository
{
    /** @return User */
    public function find(UserId $a_user_id);

    /** @return User[] */
    public function findAll();

    public function persist(User $a_user, $flush = true);

    public function remove(UserId $a_user_id, $flush = true);

    public function flush();

    /** @return User|null */
    public function findLastModified();
}
