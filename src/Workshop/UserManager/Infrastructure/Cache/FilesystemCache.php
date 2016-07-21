<?php

namespace UserManager\Infrastructure\Cache;

use UserManager\Domain\Infrastructure\Cache\Cache;
use UserManager\Domain\Infrastructure\Cache\CacheKey;

class FilesystemCache implements Cache
{
    private $cache_file_path;

    public function __construct($a_cache_file_path)
    {
        $this->cache_file_path = $a_cache_file_path;

        if (!file_exists($this->cache_file_path))
        {
            touch($this->cache_file_path);
        }
    }

    public function get(CacheKey $cache_key)
    {
        $string_content = file_get_contents($this->cache_file_path);

        $array_content = json_decode($string_content, true);

        if (empty($array_content[$cache_key->key()]))
        {
            return false;
        }

        return unserialize($array_content[$cache_key->key()]);
    }

    public function set(CacheKey $cache_key, $value)
    {
        $string_content = file_get_contents($this->cache_file_path);

        $array_content = json_decode($string_content, true);

        $array_content[$cache_key->key()] = serialize($value);

        file_put_contents($this->cache_file_path, json_encode($array_content));
    }

    public function remove(CacheKey $cache_key)
    {
        $string_content = file_get_contents($this->cache_file_path);

        $array_content = json_decode($string_content, true);

        if ($this->get($cache_key))
        {
            unset($array_content[$cache_key->key()]);
        }

        file_put_contents($this->cache_file_path, json_encode($array_content));
    }
}
