<?php

namespace UserManager\Application\Service\User\Add;

class InvalidateUserCacheWhenUserAddedRequest
{
    private $cache_key;

    public function __construct($a_cache_key)
    {
        $this->cache_key = $a_cache_key;
    }

    public function cacheKey()
    {
        return $this->cache_key;
    }
}
