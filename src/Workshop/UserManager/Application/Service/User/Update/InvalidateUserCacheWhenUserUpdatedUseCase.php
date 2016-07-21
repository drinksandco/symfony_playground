<?php

namespace UserManager\Application\Service\User\Update;

use UserManager\Domain\Infrastructure\Cache\Cache;
use UserManager\Domain\Infrastructure\Cache\CacheKey;

class InvalidateUserCacheWhenUserUpdatedUseCase
{
    /** @var Cache */
    private $cache_service;

    public function __construct(Cache $a_cache_service)
    {
        $this->cache_service = $a_cache_service;
    }
    
    public function __invoke(InvalidateUserCacheWhenUserUpdatedRequest $a_request)
    {
        $this->cache_service->remove(new CacheKey($a_request->specificUserCacheKey()));
        $this->cache_service->remove(new CacheKey($a_request->generalCacheKey()));
    }
}
