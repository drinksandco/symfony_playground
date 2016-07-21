<?php

namespace UserManager\Application\Service\User\Delete;

use UserManager\Domain\Infrastructure\Cache\Cache;
use UserManager\Domain\Infrastructure\Cache\CacheKey;

class InvalidateUserCacheWhenUserDeletedUseCase
{
    private $cache_service;

    public function __construct(Cache $a_cache_service)
    {
        $this->cache_service = $a_cache_service;
    }

    public function __invoke(InvalidateUserCacheWhenUserDeletedRequest $an_invalidate_user_cache_when_user_deleted_request)
    {
        $this->cache_service->remove(new CacheKey($an_invalidate_user_cache_when_user_deleted_request->specificUserCacheKey()));
        $this->cache_service->remove(new CacheKey($an_invalidate_user_cache_when_user_deleted_request->generalCacheKey()));
    }
}
