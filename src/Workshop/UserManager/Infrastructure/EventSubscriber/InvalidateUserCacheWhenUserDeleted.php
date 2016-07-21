<?php

namespace UserManager\Infrastructure\EventSubscriber;

use UserManager\Application\Service\User\Delete\InvalidateUserCacheWhenUserDeletedUseCase;
use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Application\Service\User\Delete\InvalidateUserCacheWhenUserDeletedRequest;

class InvalidateUserCacheWhenUserDeleted
{
    const SPECIFIC_CACHE_KEY_PREFIX = 'user_repository_findById_';
    const GENERAL_CACHE_KEY = 'user_repository_findAll';

    /** @var InvalidateUserCacheWhenUserDeletedUseCase */
    private $invalidate_user_cache_when_user_deleted_use_case;

    public function __construct(InvalidateUserCacheWhenUserDeletedUseCase $an_invalidate_user_cache_when_user_deleted_use_case)
    {
        $this->invalidate_user_cache_when_user_deleted_use_case = $an_invalidate_user_cache_when_user_deleted_use_case;
    }

    public function __invoke(UserDeleted $an_event)
    {
        $this->invalidate_user_cache_when_user_deleted_use_case->__invoke(
            new InvalidateUserCacheWhenUserDeletedRequest(self::SPECIFIC_CACHE_KEY_PREFIX . $an_event->userId(), self::GENERAL_CACHE_KEY)
        );
    }
}
