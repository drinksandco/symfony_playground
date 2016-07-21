<?php

namespace UserManager\Infrastructure\EventSubscriber\Symfony;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserManager\Domain\Infrastructure\Cache\Cache;
use UserManager\Domain\Infrastructure\Event\User\UserAdded;
use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Infrastructure\Event\Symfony\Event;
use UserManager\Domain\Infrastructure\Event\User\UserUpdated;

class InvalidateUserCacheSubscriber implements EventSubscriberInterface
{
    /** @var Cache */
    private $cache_service;

    public function __construct(Cache $a_cache_service)
    {
        $this->cache_service = $a_cache_service;
    }

    public static function getSubscribedEvents()
    {
        return [
              UserAdded::NAME => 'userAddedInvalidationCache',
              UserUpdated::NAME => 'userUpdatedInvalidationCache',
              UserDeleted::NAME => 'userDeletedInvalidationCache'
        ];
    }

    public function userAddedInvalidationCache(Event $event)
    {
        $this->cache_service->remove('user_repository_findAll');
    }

    public function userUpdatedInvalidationCache(Event $event)
    {
        /** @var UserUpdated $domain_event */
        $domain_event = $event->event();

        $this->cache_service->remove('user_repository_findAll');
        $this->cache_service->remove('user_repository_findById_' . $domain_event->userId());
    }

    public function userDeletedInvalidationCache(Event $event)
    {
        $this->cache_service->remove('user_repository_findAll');
    }
}
