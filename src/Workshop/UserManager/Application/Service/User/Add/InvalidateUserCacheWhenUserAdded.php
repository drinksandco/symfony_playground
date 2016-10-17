<?php

namespace UserManager\Application\Service\User\Add;

use UserManager\Domain\Infrastructure\Cache\Cache;
use UserManager\Domain\Infrastructure\Cache\CacheKey;
use UserManager\Application\Service\Core\ApplicationService;

class InvalidateUserCacheWhenUserAdded implements ApplicationService
{
    /** @var Cache */
    private $cache_service;

    public function __construct(Cache $a_cache_service)
    {
        $this->cache_service = $a_cache_service;
    }

    public function __invoke(InvalidateUserCacheWhenUserAddedRequest $a_request)
    {
        $cache_key_to_remove = $a_request->cacheKey();

        $this->cache_service->remove(new CacheKey($cache_key_to_remove));
    }
}
