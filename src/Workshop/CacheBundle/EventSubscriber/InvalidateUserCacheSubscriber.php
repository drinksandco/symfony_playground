<?php

namespace Workshop\CacheBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserManager\Application\EventSubscriber\InvalidateUserCacheWhenUserAddedSubscriber;
use UserManager\Application\EventSubscriber\InvalidateUserCacheWhenUserDeletedSubscriber;
use UserManager\Application\EventSubscriber\InvalidateUserCacheWhenUserUpdatedSubscriber;
use UserManager\Domain\Infrastructure\Event\User\UserAdded;
use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheEmail;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheName;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheSurname;
use UserManager\Domain\Infrastructure\Event\User\UserUpdated;
use UserManager\Infrastructure\Event\Symfony\Event;

class InvalidateUserCacheSubscriber implements EventSubscriberInterface
{
    /** @var InvalidateUserCacheWhenUserAddedSubscriber */
    private $invalidate_user_cache_when_user_added_domain_subscriber;

    /** @var InvalidateUserCacheWhenUserUpdatedSubscriber */
    private $invalidate_user_cache_when_user_updated_domain_subscriber;

    /** @var InvalidateUserCacheWhenUserDeletedSubscriber */
    private $invalidate_user_cache_when_user_deleted_domain_subscriber;

    public function __construct(
        InvalidateUserCacheWhenUserAddedSubscriber $an_invalidate_user_cache_when_user_added_domain_subscriber,
        InvalidateUserCacheWhenUserUpdatedSubscriber $an_invalidate_user_cache_when_user_updated_domain_subscriber,
        InvalidateUserCacheWhenUserDeletedSubscriber $an_invalidate_user_cache_when_user_deleted_domain_subscriber
    )
    {
        $this->invalidate_user_cache_when_user_added_domain_subscriber   = $an_invalidate_user_cache_when_user_added_domain_subscriber;
        $this->invalidate_user_cache_when_user_updated_domain_subscriber = $an_invalidate_user_cache_when_user_updated_domain_subscriber;
        $this->invalidate_user_cache_when_user_deleted_domain_subscriber = $an_invalidate_user_cache_when_user_deleted_domain_subscriber;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserAdded::NAME                => 'userAddedInvalidationCache',
            UserHasUpdatedTheName::NAME    => 'userUpdatedInvalidationCache',
            UserHasUpdatedTheSurname::NAME => 'userUpdatedInvalidationCache',
            UserHasUpdatedTheEmail::NAME   => 'userUpdatedInvalidationCache',
            UserDeleted::NAME              => 'userDeletedInvalidationCache'
        ];
    }

    public function userAddedInvalidationCache(Event $event)
    {
        $this->invalidate_user_cache_when_user_added_domain_subscriber->__invoke();
    }

    public function userUpdatedInvalidationCache(Event $event)
    {
        /** @var UserHasUpdatedTheName|UserHasUpdatedTheSurname|UserHasUpdatedTheEmail $user_updated_domain_event */
        $user_updated_domain_event = $event->event();
        $this->invalidate_user_cache_when_user_updated_domain_subscriber->__invoke($user_updated_domain_event);
    }

    public function userDeletedInvalidationCache(Event $event)
    {
        /** @var UserDeleted $user_deleted_domain_event */
        $user_deleted_domain_event = $event->event();
        $this->invalidate_user_cache_when_user_deleted_domain_subscriber->__invoke($user_deleted_domain_event);
    }
}
