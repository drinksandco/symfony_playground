<?php

namespace UserManager\Infrastructure\Cache;

use UserManager\Domain\Infrastructure\Cache\Cache;

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
        $string_content = file_get_contents($this->cache_file_path);

        $array_content = json_decode($string_content, true);

        $array_content[$key] = $value;

        file_put_contents($this->cache_file_path, json_encode($array_content));
    }

    public function remove($key)
    {
        // TODO: Implement remove() method.
    }
}
