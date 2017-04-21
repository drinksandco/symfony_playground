<?php

namespace Playground\MainBundle\EventSubscriber;

use Playground\App\Infrastructure\MessageBus\Symfony\SymfonyEvent;
use Symfony\Component\Cache\Adapter\AdapterInterface as CacheAdapter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserSubscriber implements EventSubscriberInterface
{
    /** @var CacheAdapter */
    private $cache;

    public function __construct(CacheAdapter $a_cache_adapter)
    {
        $this->cache = $a_cache_adapter;
    }

    public static function getSubscribedEvents()
    {
        return [
            'playground.user.created'       => [
                ['updateLastModified', 0]
            ],
            'playground.user.changed.email' => [
                ['updateLastModified', 0]
            ],
            'playground.user.changed.name'  => [
                ['updateLastModified', 0]
            ],
            'playground.user.removed'       => [
                ['updateLastModified', 0]
            ],
        ];
    }

    public function updateLastModified(SymfonyEvent $an_event)
    {
        $users_last_modification = $this->cache->getItem('stats.user_lsat_modification');
        $users_last_modification->set(new \DateTime());
        $this->cache->save($users_last_modification);
    }
}
