<?php

namespace UserManager\Domain\Infrastructure\Cache;

interface Cache
{
    public function get(CacheKey $key);

    public function set(CacheKey $key, $value);

    public function remove(CacheKey $key);
}
