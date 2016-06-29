<?php

namespace Workshop\CacheBundle\Repository;

use Workshop\CacheBundle\src\Domain\Infrastructure\Cache\Cache;
use Workshop\UserBundle\src\Domain\Model\User\User;
use Workshop\UserBundle\src\Domain\Model\User\ValueObject\UserId;
use Workshop\UserBundle\src\Domain\Repository\User\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    /** @var Cache */
    private $cache_service;

    public function __construct(Cache $a_cache_service)
    {
        $this->cache_service = $a_cache_service;
    }

    public function findAll()
    {
        return $this->cache_service->get('user_repository_findAll');
    }

    public function findById(UserId $user_id)
    {
        // TODO: Implement findById() method.
    }

    public function add(User $a_new_user)
    {
        // TODO: Implement add() method.
    }

    public function update(User $a_user)
    {
        // TODO: Implement update() method.
    }

    public function delete(UserId $user_id)
    {
        // TODO: Implement delete() method.
    }
}
