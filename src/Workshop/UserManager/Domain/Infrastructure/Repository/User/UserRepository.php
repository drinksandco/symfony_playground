<?php

namespace UserManager\Domain\Infrastructure\Repository\User;

use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\ValueObject\UserId;

interface UserRepository
{
    public function findAll();
    
    public function findById(UserId $user_id);
    
    public function add(User $a_new_user);
    
    public function update(User $a_user);
    
    public function delete(UserId $user_id);
}
