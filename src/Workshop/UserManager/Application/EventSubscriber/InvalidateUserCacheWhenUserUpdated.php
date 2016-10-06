<?php

namespace UserManager\Application\EventSubscriber;

use UserManager\Application\Service\User\Update\InvalidateUserCacheWhenUserUpdatedRequest;
use UserManager\Application\Service\User\Update\InvalidateUserCacheWhenUserUpdatedUseCase;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheName;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheSurname;
use UserManager\Domain\Infrastructure\Event\User\UserUpdated;

class InvalidateUserCacheWhenUserUpdated
{
    const SPECIFIC_CACHE_KEY_PREFIX = 'user_repository_findById_';
    const GENERAL_CACHE_KEY = 'user_repository_findAll';

    private $invalidate_user_cache_when_user_updated_use_case;

    public function __construct(InvalidateUserCacheWhenUserUpdatedUseCase $an_invalidate_user_cache_when_user_updated_use_case)
    {
        $this->invalidate_user_cache_when_user_updated_use_case = $an_invalidate_user_cache_when_user_updated_use_case;
    }

    /** @param UserHasUpdatedTheName|UserHasUpdatedTheSurname $an_event */
    public function __invoke($an_event)
    {
        //TODO: This EventSubscriber is called when UserHasUpdatedTheName or UserHasUpdatedTheSurname are handled
        $user_id = $an_event->userId();

        $this->invalidate_user_cache_when_user_updated_use_case->__invoke(
            new InvalidateUserCacheWhenUserUpdatedRequest(self::SPECIFIC_CACHE_KEY_PREFIX . $user_id, self::GENERAL_CACHE_KEY)
        );
    }
}