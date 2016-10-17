<?php

namespace UserManager\Application\EventSubscriber;

use UserManager\Application\Service\User\Delete\InvalidateUserCacheWhenUserDeleted;
use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Application\Service\User\Delete\InvalidateUserCacheWhenUserDeletedRequest;

class InvalidateUserCacheWhenUserDeletedSubscriber
{
    const SPECIFIC_CACHE_KEY_PREFIX = 'user_repository_findById_';
    const GENERAL_CACHE_KEY = 'user_repository_findAll';

    /** @var InvalidateUserCacheWhenUserDeleted */
    private $invalidate_user_cache_when_user_deleted;

    public function __construct(InvalidateUserCacheWhenUserDeleted $an_invalidate_user_cache_when_user_deleted)
    {
        $this->invalidate_user_cache_when_user_deleted = $an_invalidate_user_cache_when_user_deleted;
    }

    public function __invoke(UserDeleted $an_event)
    {
        $this->invalidate_user_cache_when_user_deleted->__invoke(
            new InvalidateUserCacheWhenUserDeletedRequest(self::SPECIFIC_CACHE_KEY_PREFIX . $an_event->userId(), self::GENERAL_CACHE_KEY)
        );
    }
}
