<?php

namespace UserManager\Infrastructure\EventSubscriber;

use UserManager\Application\Service\User\Add\InvalidateUserCacheWhenUserAddedRequest;
use UserManager\Application\Service\User\Add\InvalidateUserCacheWhenUserAddedUseCase;

class InvalidateUserCacheWhenUserAdded
{
    const CACHE_KEY = 'user_repository_findAll';
    
    /** @var InvalidateUserCacheWhenUserAddedUseCase */
    private $invalidate_user_cache_use_case;
    
    public function __construct(InvalidateUserCacheWhenUserAddedUseCase $an_invalidate_user_cache_use_case)
    {
        $this->invalidate_user_cache_use_case = $an_invalidate_user_cache_use_case;
    }

    public function __invoke()
    {
        $this->invalidate_user_cache_use_case->__invoke(new InvalidateUserCacheWhenUserAddedRequest(self::CACHE_KEY));
    }
}
