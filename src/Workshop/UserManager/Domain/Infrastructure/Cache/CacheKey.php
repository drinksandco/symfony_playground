<?php

namespace UserManager\Domain\Infrastructure\Cache;

use UserManager\Domain\Infrastructure\Cache\Exception\InvalidCacheKeyException;

class CacheKey
{
    private $key;

    public function __construct($raw_key)
    {
        $this->setKey($raw_key);
    }

    private function setKey($raw_key)
    {
        $this->assertValidStringKey($raw_key);
        $this->key = $raw_key;
    }

    private function assertValidStringKey($key)
    {
        if (!preg_match('/[a-zA-Z0-9]+/', $key))
        {
            throw new InvalidCacheKeyException('Is not a valid string');
        }
    }

    public function key()
    {
        return $this->key;
    }
}
