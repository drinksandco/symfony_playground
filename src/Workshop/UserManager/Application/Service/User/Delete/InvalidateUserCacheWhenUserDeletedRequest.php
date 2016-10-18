<?php

namespace UserManager\Application\Service\User\Delete;

class InvalidateUserCacheWhenUserDeletedRequest
{
    private $specific_user_cache_key;
    
    private $general_cache_key;
    
    public function __construct($a_specific_user_cache_key, $a_general_cache_key)
    {
        $this->specific_user_cache_key = $a_specific_user_cache_key;
        $this->general_cache_key = $a_general_cache_key;
    }

    public function specificUserCacheKey()
    {
        return $this->specific_user_cache_key;
    }

    public function generalCacheKey()
    {
        return $this->general_cache_key;
    }
}
