<?php

namespace Obokaman\Domain\Infrastructure\Repository\User;

use Obokaman\Domain\User\Email;
use Obokaman\Domain\User\User;
use Obokaman\Domain\User\UserId;

interface UserRepository
{
    /** @return User */
    public function find(UserId $a_user_id);

    /** @return User */
    public function findByEmail(Email $an_user_email);

    /** @return User[] */
    public function findAll();

    public function persist(User $a_user, $flush = true);

    public function remove(UserId $a_user_id, $flush = true);

    public function flush();
}
