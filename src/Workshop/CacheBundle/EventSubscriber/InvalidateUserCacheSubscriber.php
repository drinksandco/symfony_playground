<?php

namespace Workshop\CacheBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserManager\Domain\Infrastructure\Event\User\UserAdded;
use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Domain\Infrastructure\Event\User\UserUpdated;
use UserManager\Infrastructure\Event\Symfony\Event;
use UserManager\Application\EventSubscriber\InvalidateUserCacheWhenUserAdded;
use UserManager\Application\EventSubscriber\InvalidateUserCacheWhenUserDeleted;
use UserManager\Application\EventSubscriber\InvalidateUserCacheWhenUserUpdated;

class InvalidateUserCacheSubscriber implements EventSubscriberInterface
{
    /** @var InvalidateUserCacheWhenUserAdded */
    private $invalidate_user_cache_when_user_added_domain_subscriber;

    /** @var InvalidateUserCacheWhenUserUpdated */
    private $invalidate_user_cache_when_user_updated_domain_subscriber;

    /** @var InvalidateUserCacheWhenUserDeleted */
    private $invalidate_user_cache_when_user_deleted_domain_subscriber;

    public function __construct(
        InvalidateUserCacheWhenUserAdded $an_invalidate_user_cache_when_user_added_domain_subscriber,
        InvalidateUserCacheWhenUserUpdated $an_invalidate_user_cache_when_user_updated_domain_subscriber,
        InvalidateUserCacheWhenUserDeleted $an_invalidate_user_cache_when_user_deleted_domain_subscriber
    )
    {
        $this->invalidate_user_cache_when_user_added_domain_subscriber = $an_invalidate_user_cache_when_user_added_domain_subscriber;
        $this->invalidate_user_cache_when_user_updated_domain_subscriber = $an_invalidate_user_cache_when_user_updated_domain_subscriber;
        $this->invalidate_user_cache_when_user_deleted_domain_subscriber = $an_invalidate_user_cache_when_user_deleted_domain_subscriber;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserAdded::NAME   => 'userAddedInvalidationCache',
            UserUpdated::NAME => 'userUpdatedInvalidationCache',
            UserDeleted::NAME => 'userDeletedInvalidationCache'
        ];
    }

    public function userAddedInvalidationCache(Event $event)
    {
        $this->invalidate_user_cache_when_user_added_domain_subscriber->__invoke();
    }

    public function userUpdatedInvalidationCache(Event $event)
    {
        /** @var UserUpdated $user_updated_domain_event */
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
