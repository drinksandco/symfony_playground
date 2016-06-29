<?php

namespace Workshop\CacheBundle\src\Domain\Infrastructure\Cache;

interface Cache
{
    public function get($key);

    public function set($key, $value);

    public function remove($key);
}
