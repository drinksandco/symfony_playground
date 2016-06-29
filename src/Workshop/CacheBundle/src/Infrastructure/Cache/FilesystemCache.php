<?php

namespace Workshop\CacheBundle\src\Infrastructure\Cache;

use Workshop\CacheBundle\src\Domain\Infrastructure\Cache\Cache;

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

    public function get($key)
    {
        $string_content = file_get_contents($this->cache_file_path);
        
        $value = json_decode($string_content, true)[$key];
        
        if (empty($value))
        {
            return false;
        }
        
        return $value;
    }

    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    public function remove($key)
    {
        // TODO: Implement remove() method.
    }
}
