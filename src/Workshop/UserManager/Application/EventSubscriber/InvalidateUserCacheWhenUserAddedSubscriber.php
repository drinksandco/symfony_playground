<?php

namespace UserManager\Application\EventSubscriber;

use UserManager\Application\Service\User\Add\InvalidateUserCacheWhenUserAddedRequest;
use UserManager\Application\Service\User\Add\InvalidateUserCacheWhenUserAdded;

class InvalidateUserCacheWhenUserAddedSubscriber
{
    const CACHE_KEY = 'user_repository_findAll';

    /** @var InvalidateUserCacheWhenUserAdded */
    private $invalidate_user_cache;

    public function __construct(InvalidateUserCacheWhenUserAdded $an_invalidate_user_cache)
    {
        $this->invalidate_user_cache = $an_invalidate_user_cache;
    }

    public function __invoke()
    {
        $this->invalidate_user_cache->__invoke(new InvalidateUserCacheWhenUserAddedRequest(self::CACHE_KEY));
    }
}
