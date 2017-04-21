<?php

namespace Playground\CacheBundle\Repository;

use Doctrine\Common\Cache\PhpFileCache;
use Playground\App\Domain\Infrastructure\Repository\User\UserRepository;
use Playground\App\Domain\Model\User\User;
use Playground\App\Domain\Model\User\UserId;

class CachedUserRepository implements UserRepository
{
    const LIST_CACHE_KEY = 'users_list_cache';

    /** @var UserRepository */
    private $original_repo;

    /** @var PhpFileCache */
    private $cache;

    public function __construct(UserRepository $an_original_repo, PhpFileCache $a_cache_adapter)
    {
        $this->original_repo = $an_original_repo;
        $this->cache         = $a_cache_adapter;
        $this->cache->setNamespace('users');
    }

    public function find(UserId $a_user_id)
    {
        return $this->original_repo->find($a_user_id);
    }

    public function findAll()
    {
        if ($this->cache->contains(self::LIST_CACHE_KEY))
        {
            $results = $this->cache->fetch(self::LIST_CACHE_KEY);
            $results = unserialize($results);

            return $results;
        }

        $result = $this->original_repo->findAll();

        $this->cache->save(self::LIST_CACHE_KEY, serialize($result), 60);

        return $result;
    }

    public function persist(User $a_user, $flush = true)
    {
        return $this->original_repo->persist($a_user, $flush);
    }

    public function remove(UserId $a_user_id, $flush = true)
    {
        return $this->original_repo->remove($a_user_id, $flush);
    }

    public function flush()
    {
        return $this->original_repo->flush();
    }
}
