<?php

namespace UserManager\Application\EventSubscriber;

use UserManager\Application\Service\User\Update\InvalidateUserCacheWhenUserUpdatedRequest;
use UserManager\Application\Service\User\Update\InvalidateUserCacheWhenUserUpdated;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheName;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheSurname;
use UserManager\Domain\Infrastructure\Event\User\UserUpdated;

class InvalidateUserCacheWhenUserUpdatedSubscriber
{
    const SPECIFIC_CACHE_KEY_PREFIX = 'user_repository_findById_';
    const GENERAL_CACHE_KEY = 'user_repository_findAll';


    private $invalidate_user_cache_when_user_updated;

    public function __construct(InvalidateUserCacheWhenUserUpdated $an_invalidate_user_cache_when_user_updated)
    {
        $this->invalidate_user_cache_when_user_updated = $an_invalidate_user_cache_when_user_updated;
    }

    /** @param UserHasUpdatedTheName|UserHasUpdatedTheSurname $an_event */
    public function __invoke($an_event)
    {
        //TODO: This EventSubscriber is called when UserHasUpdatedTheName or UserHasUpdatedTheSurname are handled
        $user_id = $an_event->userId();

        $this->invalidate_user_cache_when_user_updated->__invoke(
            new InvalidateUserCacheWhenUserUpdatedRequest(self::SPECIFIC_CACHE_KEY_PREFIX . $user_id, self::GENERAL_CACHE_KEY)
        );
    }
}
