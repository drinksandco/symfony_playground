<?php

namespace Obokaman\Playground\Domain\Infrastructure\Repository\User;

use Obokaman\Playground\Domain\Model\User\Email;
use Obokaman\Playground\Domain\Model\User\User;
use Obokaman\Playground\Domain\Model\User\UserId;

interface UserRepository
{
    /** @return User */
    public function find(UserId $a_user_id);

    /** @return User[] */
    public function findAll();

    public function persist(User $a_user, $flush = true);

    public function remove(UserId $a_user_id, $flush = true);

    public function flush();
}
