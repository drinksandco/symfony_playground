<?php

namespace OboCacheBundle\EventSubscriber;

use Doctrine\Common\Cache\PhpFileCache;
use OboCacheBundle\Repository\CachedUserRepository;
use Obokaman\Infrastructure\Event\Symfony\SymfonyEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserSubscriber implements EventSubscriberInterface
{
    /** @var PhpFileCache */
    private $cache;

    public function __construct(PhpFileCache $a_cache_adapter)
    {
        $this->cache = $a_cache_adapter;
        $this->cache->setNamespace('users');
    }

    public static function getSubscribedEvents()
    {
        return [
            'obokaman.user.created'       => [
                ['clearCache', 0]
            ],
            'obokaman.user.changed.email' => [
                ['clearCache', 0]
            ],
            'obokaman.user.changed.name'  => [
                ['clearCache', 0]
            ],
            'obokaman.user.removed'       => [
                ['clearCache', 0]
            ],
        ];
    }

    public function clearCache(SymfonyEvent $an_event)
    {
        $this->cache->delete(CachedUserRepository::LIST_CACHE_KEY);
    }
}
