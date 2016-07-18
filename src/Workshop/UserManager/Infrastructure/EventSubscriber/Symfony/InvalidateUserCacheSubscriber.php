<?php

namespace UserManager\Infrastructure\EventSubscriber\Symfony;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserManager\Domain\Infrastructure\Cache\Cache;
use UserManager\Domain\Infrastructure\Event\User\UserAdded;
use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Infrastructure\Event\Symfony\Event;

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
              UserDeleted::NAME => 'userDeletedInvalidationCache'
        ];
    }

    public function userAddedInvalidationCache(Event $event)
    {
        $this->cache_service->remove('user_repository_findAll');
    }

    public function userDeletedInvalidationCache(Event $event)
    {
        $this->cache_service->remove('user_repository_findAll');
    }
}
